<?php

namespace App\Http\Controllers;

use App\Models\Boletin;
use App\Models\Cursos;
use App\Models\Inscritos;
use App\Models\NotaEntrega;
use App\Models\NotaEvaluacion;
use App\Models\Notas_Boletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Swift_Message;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Attachment;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Message;
use App\Mail\BoletinCorreo;
use App\Models\Actividad;
use Spatie\Browsershot\Browsershot;


class BoletinController extends Controller
{


    public function boletin($id)
{
    // Obtener el inscrito con todas las relaciones necesarias
    $inscritos = Inscritos::with([
        'cursos.temas.subtemas.actividades.tiposEvaluacion',
        'cursos.temas.subtemas.actividades.cuestionarios.intentos',
        'cursos.temas.subtemas.actividades.calificacionesEntregas'
    ])->findOrFail($id);

    // Organizar las notas por temas y subtemas
    $notasPorTema = $inscritos->cursos->temas->map(function ($tema) use ($inscritos) {
        return [
            'tema' => $tema->titulo,
            'subtemas' => $tema->subtemas->map(function ($subtema) use ($inscritos) {
                return [
                    'subtema' => $subtema->titulo_subtema,
                    'actividades' => $subtema->actividades->map(function ($actividad) use ($inscritos) {
                        // Obtener los tipos de evaluación de la actividad
                        $tiposEvaluacion = $actividad->tiposEvaluacion;

                        $notas = collect();

                        foreach ($tiposEvaluacion as $tipoEvaluacion) {
                            if ($tipoEvaluacion->slug === 'cuestionario') {
                                // Procesar notas de cuestionarios
                                $notasCuestionario = collect(optional($actividad->cuestionarios))->flatMap(function ($cuestionario) use ($inscritos) {
                                    return collect(optional($cuestionario->intentos))
                                        ->filter(function ($intento) use ($inscritos) {

                                            dd($intento->inscrito_id    );
                                            return $intento->inscrito_id == $inscritos->id;  // Changed from inscripcion_id to inscrito_id
                                        })
                                        ->map(function ($intento) use ($cuestionario, $tipoEvaluacion) {
                                            return [
                                                'tipo' => 'Cuestionario',
                                                'tipo_evaluacion' => $tipoEvaluacion->nombre,
                                                'actividad' => $cuestionario->titulo ?? 'Sin título',
                                                'nota' => $intento->calificacion ?? 0,
                                                'puntaje_maximo' => $tipoEvaluacion->pivot->puntaje_maximo ?? 100,
                                                'es_obligatorio' => $tipoEvaluacion->pivot->es_obligatorio,
                                                'comentario' => $intento->comentario ?? 'Sin comentario',
                                                'fecha' => $intento->created_at ?? now(),
                                            ];
                                        });
                                });
                                $notas = $notas->merge($notasCuestionario);
                            } else {
                                // Procesar notas de entregas
                                $notasEntrega = $actividad->calificacionesEntregas
                                    ->filter(function ($nota) use ($inscritos) {
                                        return $nota->inscripcion_id == $inscritos->id;
                                    })
                                    ->map(function ($nota) use ($tipoEvaluacion) {
                                        return [
                                            'tipo' => 'Entrega',
                                            'tipo_evaluacion' => $tipoEvaluacion->nombre,
                                            'actividad' => $nota->actividad->titulo ?? 'Sin título',
                                            'nota' => $nota->nota ?? 0,
                                            'puntaje_maximo' => $tipoEvaluacion->pivot->puntaje_maximo ?? 100,
                                            'es_obligatorio' => $tipoEvaluacion->pivot->es_obligatorio,
                                            'comentario' => $nota->retroalimentacion ?? 'Sin comentario',
                                            'fecha' => $nota->created_at ?? now(),
                                        ];
                                    });
                                $notas = $notas->merge($notasEntrega);
                            }
                        }

                        return [
                            'actividad' => $actividad->titulo,
                            'descripcion' => $actividad->descripcion,
                            'fecha_inicio' => $actividad->fecha_inicio,
                            'fecha_fin' => $actividad->fecha_fin,
                            'notas' => $notas,
                        ];
                    }),
                ];
            }),
        ];
    });

    // Calcular estadísticas generales
    $estadisticas = [
        'total_actividades' => $notasPorTema->pluck('subtemas.*.actividades')->flatten(2)->count(),
        'actividades_calificadas' => $notasPorTema->pluck('subtemas.*.actividades.*.notas')->flatten(3)->count(),
        'promedio_general' => $notasPorTema->pluck('subtemas.*.actividades.*.notas.*.nota')->flatten()->average() ?? 0,
    ];

    return view('Estudiante.boletin', compact('inscritos', 'notasPorTema', 'estadisticas'));
}


    public function boletinEstudiantes($id)
    {

        $curso = Cursos::findOrFail($id);

        $inscritos = Inscritos::where('cursos_id', $id)
            ->where('estudiante_id', auth()->user()->id)
            ->first(); // Cambia "get" a "first" para obtener un solo resultado

        $boletin = null; // Inicializa $boletin como null por defecto

        if ($inscritos) {
            $boletin = Boletin::where('inscripcion_id', $inscritos->id)->first();
            $boletinNotas = Notas_Boletin::where('boletin_id', $boletin->id)->get();
        }

        return view('Estudiante.boletin')->with('curso', $curso)->with('inscritos', $inscritos)->with('boletin', $boletin)->with('boletinNotas', $boletinNotas);
    }


    public function boletinEstudiantes2($id)
    {

        $inscritos = Inscritos::findOrFail($id);


        $boletinNotas = [];
        $boletin = null;
        if ($inscritos) {
            $boletin = Boletin::where('inscripcion_id', $inscritos->id)->first();

            // Verificar si $boletin es null antes de buscar notas del boletín
            if ($boletin) {
                $boletinNotas = Notas_Boletin::where('boletin_id', $boletin->id)->get();
            }
        }

        return view('Estudiante.boletin2')->with('inscritos', $inscritos)->with('boletin', $boletin)->with('boletinNotas', $boletinNotas);
    }













    public function listarNotasActividad($actividadId)
    {
        // Obtener la actividad con sus relaciones
        $actividad = Actividad::with(['entregasNotas', 'intentosEstudiante'])->findOrFail($actividadId);

        // Notas de las entregas
        $notasEntregas = $actividad->entregasNotas->map(function ($nota) {
            return [
                'tipo' => 'Entrega',
                'nota' => $nota->nota,
                'comentario' => $nota->retroalimentacion,
                'fecha' => $nota->created_at,
            ];
        });

        // Notas de los intentos de cuestionarios
        $notasCuestionarios = $actividad->intentosEstudiante->map(function ($intento) {
            return [
                'tipo' => 'Cuestionario',
                'nota' => $intento->calificacion,
                'comentario' => $intento->comentario ?? 'Sin comentario',
                'fecha' => $intento->created_at,
            ];
        });

        // Combinar ambas ramas
        $notasCombinadas = $notasEntregas->merge($notasCuestionarios);

        return view('Estudiante.NotasActividad', [
            'actividad' => $actividad,
            'notas' => $notasCombinadas,
        ]);
    }


    public function guardar_boletin(Request $request)
    {


        $request->validate([
            'estudiante' => 'required',
            'notafinal' => 'required|numeric',
            'comentario' => 'required|string',
            'evaluaciones' => 'required|string',
            'notaEvaluacion' => 'required|numeric',
            'tareas' => 'required|string',
            'notaTarea' => 'required|numeric',
        ], [
            'estudiante.required' => 'El campo estudiante es obligatorio.',
            'notafinal.required' => 'El campo nota final es obligatorio.',
            'notafinal.numeric' => 'El campo nota final debe ser numérico.',
            'comentario.required' => 'El campo comentario es obligatorio.',
            'comentario.string' => 'El campo comentario debe ser una cadena de texto.',
            'evaluaciones.required' => 'No se encontraron notas para este estudiante.',
            'evaluaciones.string' => 'No se encontraron notas para este estudiante.',
            'notaEvaluacion.required' => 'No se encontraron notas para este estudiante.',
            'notaEvaluacion.numeric' => 'No se encontraron notas para este estudiante.',
            'tareas.required' => 'No se encontraron notas para este estudiante.',
            'tareas.string' => 'El campo tareas debe ser una cadena de texto.',
            'notaTarea.required' => 'El campo nota de tarea es obligatorio.',
            'notaTarea.numeric' => 'El campo nota de tarea debe ser numérico.',
        ]);

        $estudianteId = $request->estudiante;


        $boletin = Boletin::where('inscripcion_id', $estudianteId)->first();

        if (!$boletin) {
            $boletin = new Boletin;
            $boletin->inscripcion_id = $estudianteId;
            $boletin->nota_final = $request->notafinal;
            $boletin->comentario_boletin = $request->comentario;
            $boletin->save();
        } else {
            $boletin->nota_final = $request->notafinal;
            $boletin->comentario_boletin = $request->comentario;
            $boletin->save();
        }

        if ($boletin->notasBoletin->isEmpty()) {
            $boletinNotas1 = new Notas_Boletin;
            $boletinNotas1->boletin_id = $boletin->id;
            $boletinNotas1->nota_nombre = $request->evaluaciones;
            $boletinNotas1->nota = $request->notaEvaluacion;
            $boletinNotas1->save();

            $boletinNotas2 = new Notas_Boletin;
            $boletinNotas2->boletin_id = $boletin->id;
            $boletinNotas2->nota_nombre = $request->tareas;
            $boletinNotas2->nota = $request->notaTarea;
            $boletinNotas2->save();
        } else {
            $boletinNotas1 = $boletin->notasBoletin->firstWhere('nota_nombre', $request->evaluaciones);
            if ($boletinNotas1) {
                $boletinNotas1->nota = $request->notaEvaluacion;
                $boletinNotas1->save();
            }

            $boletinNotas2 = $boletin->notasBoletin->firstWhere('nota_nombre', $request->tareas);
            if ($boletinNotas2) {
                $boletinNotas2->nota = $request->notaTarea;
                $boletinNotas2->save();
            }
        }

        return back()->with('success', 'El boletin se ha guardado correctamente, puede verlo en ver calificaciones finales');
    }



    public function enviarBoletin(Request $request, $id)
    {
        $inscritos = Inscritos::findOrFail($id);
        $boletinNotas = [];
        $boletin = null;

        if ($inscritos) {
            $boletin = Boletin::where('inscripcion_id', $inscritos->id)->first();
            // Verificar si $boletin es null antes de buscar notas del boletín
            if ($boletin) {
                $boletinNotas = Notas_Boletin::where('boletin_id', $boletin->id)->get();
            }
        }


        if ($inscritos) {
            $imageUrl = secure_asset('assets/img/logof.png');
            $imageUrl2 = secure_asset('assets/img/logoedin.png');
            $imageUrl3 = secure_asset('assets/img/firma digital.png');

            $htmlContent = view('Estudiante.boletin3')
                ->with('imageUrl', $imageUrl)
                ->with('imageUrl2', $imageUrl2)
                ->with('imageUrl3', $imageUrl3)
                ->with('inscritos', $inscritos)
                ->with('boletin', $boletin)
                ->with('boletinNotas', $boletinNotas)
                ->render();

            $tempHtmlFile = tempnam(sys_get_temp_dir(), 'boletin');
            file_put_contents($tempHtmlFile, $htmlContent);

            $transport = (new Swift_SmtpTransport('smtp-relay.sendinblue.com', 587))
                ->setUsername('correopruebas015@gmail.com')
                ->setPassword('KAFrt15YxhU6Oc4y');

            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message('Asunto del correo'))
                ->setFrom(['educarparalavida.fund@gmail.com' => 'Fundacion Educar Para la Vida'])
                ->setTo([$inscritos->estudiantes->email])
                ->setBody("Boletin de notas") // Puedes personalizar esto según tus necesidades.
                ->attach(Swift_Attachment::fromPath($tempHtmlFile, 'text/html'));

            $result = $mailer->send($message);






            unlink($tempHtmlFile);




            if ($result) {


                return 'Correo con contenido HTML como adjunto enviado con éxito.';
            } else {


                return 'Error al enviar el correo con contenido HTML como adjunto.';
            }
        } else {
            return 'Error al enviar el correo. Correo de destino no disponible.';
        }
    }
}
