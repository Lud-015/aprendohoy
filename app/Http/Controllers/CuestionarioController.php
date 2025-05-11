<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Cuestionario;
use App\Models\Inscritos;
use App\Models\IntentoCuestionario;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\RespuestaEstudiante;
use App\Models\Resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuestionarioController extends Controller
{
    public function index($id)
    {
        $cuestionario = Cuestionario::with(['preguntas' => function ($query) {
            $query->withTrashed()->with(['respuestas' => function ($query) {}]);
        }])->findOrFail($id);


        return view('Docente.respuestas')->with('cuestionario', $cuestionario);
    }

    public function mostrarCuestionario($id)
    {
        $cuestionario = Cuestionario::with(['preguntas.respuestas'])->findOrFail($id);

        if ($cuestionario->preguntas->isEmpty()) {
            return redirect()->route('Curso', $cuestionario->actividad->subtema->tema->curso->id)
                ->with('error', 'Este cuestionario no tiene preguntas disponibles.');
        }

        $inscripcion = Inscritos::where('estudiante_id', Auth::id())
            ->where('cursos_id', $cuestionario->actividad->subtema->tema->curso->id)
            ->firstOrFail();

        // Obtener el número de intentos realizados
        $intentosRealizados = IntentoCuestionario::where('cuestionario_id', $id)
            ->where('inscrito_id', $inscripcion->id)
            ->count();

        // Verificar si se alcanzó el número máximo de intentos
        if ($intentosRealizados >= $cuestionario->max_intentos) {
            return redirect()->route('Curso', $cuestionario->actividad->subtema->tema->curso->id)
                ->with('error', 'Has alcanzado el número máximo de intentos para este cuestionario.');
        }

        // Registrar un nuevo intento
        $nuevoIntento = IntentoCuestionario::create([
            'inscrito_id' => $inscripcion->id,
            'intento_numero' => $intentosRealizados + 1,
            'cuestionario_id' => $id,
            'iniciado_en' => now(),
        ]);

        session(["inicio_cuestionario_{$id}" => now()]);

        return view('Estudiante.cuestionario_resolve', compact('cuestionario', 'inscripcion', 'nuevoIntento'));
    }

    public function registrarAbandono($id)
    {
        $inscrito = Inscritos::where('estudiante_id', Auth::id())
            ->where('cursos_id', Cuestionario::findOrFail($id)->actividad->subtema->tema->curso->id)
            ->first();

        if ($inscrito) {
            // Verificar si ya existe un intento en progreso
            $intentoExistente = IntentoCuestionario::where('cuestionario_id', $id)
                ->where('inscrito_id', $inscrito->id)
                ->whereNull('finalizado_en')
                ->first();

            if ($intentoExistente) {
                // Finalizar el intento con nota 0
                $intentoExistente->update([
                    'nota' => 0,
                    'aprobado' => false,
                    'finalizado_en' => now(),
                ]);
            }
        }

        return response()->noContent(); // Responder sin contenido
    }

    public function eliminarCuestionario($id)
    {
        $cuestionario = Cuestionario::find($id);

        if (!$cuestionario) {
            return redirect()->back()->with('error', 'El cuestionario no existe.');
        }

        // Eliminar el cuestionario
        $cuestionario->delete();

        return redirect()->route('rankingQuizz')->with('success', 'El cuestionario ha sido eliminado correctamente.');
    }

    public function eliminarIntento($intentoId)
    {
        $intento = IntentoCuestionario::find($intentoId);

        if (!$intento) {
            return redirect()->back()->with('error', 'El intento no existe.');
        }

        // Eliminar el intento
        $intento->delete();

        return redirect()->back()->with('success', 'El intento ha sido eliminado correctamente.');
    }

    public function procesarRespuestas(Request $request, $id)
    {
        // Validar que el cuestionario exista



        $cuestionario = Cuestionario::with('preguntas.respuestas')->findOrFail($id);


        // Obtener el ID del inscrito basado en el estudiante autenticado y el curso
        $inscrito = Inscritos::where('estudiante_id', Auth::id())
            ->where('cursos_id', $cuestionario->actividad->subtema->tema->curso->id)
            ->firstOrFail();

        $inscritoId = $inscrito->id;

        // Verificar si ya existe un intento en progreso
        $intento = IntentoCuestionario::where('cuestionario_id', $id)
            ->where('inscrito_id', $inscritoId)
            ->whereNull('finalizado_en')
            ->first();

        // Si no existe un intento en progreso, crea uno nuevo
        if (!$intento) {
            $intento = IntentoCuestionario::create([
                'inscrito_id' => $inscritoId,
                'cuestionario_id' => $id,
                'intento_numero' => IntentoCuestionario::where('cuestionario_id', $id)
                    ->where('inscrito_id', $inscritoId)
                    ->count() + 1,
                'iniciado_en' => now(),
            ]);
        }

        $intentoId = $intento->id;

        // Obtener las respuestas enviadas desde el formulario
        $respuestas = $request->input('respuestas', []);

        // Inicializar variables para el puntaje
        $puntajeObtenido = 0;
        $puntajeTotal = 0;

        // Iterar sobre las respuestas enviadas
        foreach ($respuestas as $preguntaId => $respuesta) {
            $pregunta = Pregunta::with('respuestas')->findOrFail($preguntaId);
            $puntajeTotal += $pregunta->puntaje;

            if ($pregunta->tipo === 'abierta') {
                $respuestasClave = $pregunta->respuestas->where('es_correcta', true)->pluck('contenido')->toArray();
                $esCorrecta = in_array(strtolower(trim($respuesta)), array_map('strtolower', $respuestasClave));

                if ($esCorrecta) {
                    $puntajeObtenido += $pregunta->puntaje;
                }

                RespuestaEstudiante::create([
                    'inscrito_id' => $inscritoId,
                    'intento_id' => $intentoId, // Relacionar con el intento actual
                    'pregunta_id' => $preguntaId,
                    'respuesta' => $respuesta,
                    'es_correcta' => $esCorrecta,
                ]);
            } else if ($pregunta->tipo === 'boolean') {
                $respuestaSeleccionada = $respuesta == 1 ? 'Verdadero' : 'Falso';
                $esCorrecta = $pregunta->respuestas->where('contenido', $respuestaSeleccionada)->where('es_correcta', true)->isNotEmpty();

                if ($esCorrecta) {
                    $puntajeObtenido += $pregunta->puntaje;
                }

                RespuestaEstudiante::create([
                    'inscrito_id' => $inscritoId,
                    'intento_id' => $intentoId, // Relacionar con el intento actual
                    'pregunta_id' => $preguntaId,
                    'respuesta' => $respuestaSeleccionada,
                    'es_correcta' => $esCorrecta,
                ]);
            } else {
                $respuestaSeleccionada = $pregunta->respuestas->where('id', $respuesta)->first();
                $esCorrecta = $respuestaSeleccionada && $respuestaSeleccionada->es_correcta;

                if ($esCorrecta) {
                    $puntajeObtenido += $pregunta->puntaje;
                }

                RespuestaEstudiante::create([
                    'inscrito_id' => $inscritoId,
                    'intento_id' => $intentoId, // Relacionar con el intento actual
                    'pregunta_id' => $preguntaId,
                    'respuesta' => $respuestaSeleccionada ? $respuestaSeleccionada->contenido : null,
                    'es_correcta' => $esCorrecta,
                ]);
            }
        }

        // Guardar el resultado del intento
        IntentoCuestionario::create([
            'inscrito_id' => $inscritoId,
            'cuestionario_id' => $id,
            'intento_numero' => 1, // Asignar el número de intento
            'nota' => $puntajeObtenido,
            'aprobado' => $puntajeObtenido >= ($puntajeTotal * 0.6), // Ejemplo: 60% para aprobar
            'iniciado_en' => session("inicio_cuestionario_{$id}"),
            'finalizado_en' => now(),
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('rankingQuizz', $id)
            ->with('success', "Cuestionario completado. Puntaje obtenido: {$puntajeObtenido}/{$puntajeTotal}.");
    }


    public function store(Request $request, $actividadId)
    {
        $request->validate([
            'mostrar_resultados' => 'required|boolean',
            'max_intentos' => 'required|integer|min:1',
            'tiempo_limite' => 'nullable|integer|min:1',
        ]);


        $actividad = Actividad::findOrFail($actividadId);

        if ($actividad->cuestionario) {
            return back()->with('error', 'Esta actividad ya tiene un cuestionario asociado.');
        }

        Cuestionario::create([
            'actividad_id' => $actividadId,
            'mostrar_resultados' => $request->mostrar_resultados,
            'max_intentos' => $request->max_intentos,
            'tiempo_limite' => $request->tiempo_limite,
        ]);

        return back()->with('success', 'Cuestionario creado correctamente.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'mostrar_resultados' => 'required|boolean',
            'max_intentos' => 'required|integer|min:1',
            'tiempo_limite' => 'nullable|integer|min:1',
        ]);

        $cuestionario = Cuestionario::findOrFail($id);

        $cuestionario->update([
            'mostrar_resultados' => $request->mostrar_resultados,
            'max_intentos' => $request->max_intentos,
            'tiempo_limite' => $request->tiempo_limite,
        ]);

        return back()->with('success', 'Cuestionario actualizado correctamente.');
    }




    public function delete($id)
    {
        Cuestionario::find($id)->delete();
        return back()->with('success', 'Cuestionario Eliminado Correctamente');
    }

    public function restore($id)
    {
        Cuestionario::find($id)->restore();
        return back()->with('success', 'Cuestionario Restablecido Correctamente');
    }



    public function rankingQuizz($cuestionarioId)
    {
        $user = Auth::user();

        if ($user->hasRole('Estudiante')) {
            $mejoresIntentos = IntentoCuestionario::whereHas('inscrito', function ($query) use ($user) {
                $query->where('estudiante_id', $user->id);
            })
                ->where('cuestionario_id', $cuestionarioId) // Filtrar por el cuestionario específico
                ->with('cuestionario')
                ->orderByDesc('nota')
                ->get();
            return view('Estudiante.rankingquizz', compact('mejoresIntentos'));
        } elseif ($user->hasRole('Docente')) {
            $cuestionario = Cuestionario::with(['intentos' => function ($query) {
                $query->with('inscrito')->orderByDesc('nota');
            }])->findOrFail($cuestionarioId);




            // Pasar los datos a la vista
            return view('Estudiante.rankingquizz', compact('cuestionario'));
        }

        return redirect()->back()->with('error', 'No tienes acceso a esta sección.');
    }


    public function revisarIntento($cuestionarioId, $intentoId)
    {
        $intento = IntentoCuestionario::findOrFail($intentoId);


        return view('Docente.revisar_intento', compact('intento'));
    }

    public function actualizarNota(Request $request, $cuestionarioId, $intentoId)
    {
        $request->validate([
            'nota' => 'required|numeric|min:0|max:100', // Ajusta el rango según tus necesidades
        ]);

        $intento = IntentoCuestionario::where('id', $intentoId)
            ->where('cuestionario_id', $cuestionarioId)
            ->firstOrFail();

        $intento->update([
            'nota' => $request->nota,
            'aprobado' => $request->nota >= 60, // Ejemplo: 60% para aprobar
        ]);

        return redirect()->route('cuestionarios.revisarIntento', [$cuestionarioId, $intentoId])
            ->with('success', 'La nota ha sido actualizada correctamente.');
    }
}
