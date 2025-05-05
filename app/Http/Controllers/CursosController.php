<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Boletin;
use App\Models\Cursos;
use App\Models\Cursos_Horario;
use App\Models\EdadDirigida;
use App\Models\Evaluaciones;
use App\Models\Foro;
use App\Models\Horario;
use App\Models\Inscritos;
use App\Models\Nivel;
use App\Models\NotaEntrega;
use App\Models\NotaEvaluacion;
use App\Models\Recursos;
use App\Models\Tareas;
use App\Models\Temas;
use App\Models\TareasEntrega;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Auth;
use App\Charts\BartChart;
use App\Events\CursoEvent;
use App\Helpers\TextHelper;
use App\Models\CertificateTemplate;
use App\Models\Tema;
use App\Models\TipoActividad;
use App\Services\QrTokenService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ protected $qrTokenService;

    public function __construct(QrTokenService $qrTokenService)
    {
        $this->qrTokenService = $qrTokenService;
    }

    public function index($id)
    {
        // Obtener el curso
        $cursos = Cursos::findOrFail($id);

        // Obtener el template del certificado
        $certificado_template = CertificateTemplate::where('curso_id', $id)->first();

        // Verificar si el usuario está inscrito en el curso
        $inscritos = Inscritos::where('cursos_id', $id)
            ->where('estudiante_id', auth()->user()->id)
            ->exists();  // Esto devuelve un booleano

        // Verificar si el pago está completado
        $pago_completado = Inscritos::where('cursos_id', $id)
            ->where('estudiante_id', auth()->user()->id)
            ->pluck('pago_completado')->first(); // Esto devuelve un solo valor

        $user = Auth::user();
        $esEstudiante = $user->hasRole('Estudiante');
        $esDocente = $user->id == $cursos->docente_id;
        $pagoIncompleto = $pago_completado == 0; // Aquí comparamos con 0 si no ha completado el pago
        $esCursoNormal = $cursos->tipo == 'curso';

        // Si es estudiante y no está inscrito
        if (!$inscritos && $esEstudiante) {
            return redirect()->back()->with('error', 'No estás inscrito en este curso.');
        }

        // Si es estudiante y no ha completado el pago de un curso normal
        elseif ($esEstudiante && $esCursoNormal && $pagoIncompleto) {
            return view('LoadingPage.Loading');
        }



        // Obtener recursos, temas, evaluaciones, foros y horarios
        $recursos = Recursos::where('cursos_id', $id)->get();
        $temas = Tema::where('curso_id', $id)->get();
        $foros = Foro::where('cursos_id', $id)->get();

        $horarios = Auth::user()->hasRole(['Administrador', 'Docente'])
            ? Cursos_Horario::where('curso_id', $id)->withTrashed()->get()
            : Cursos_Horario::where('curso_id', $id)->get();

        // Obtener el boletín del usuario
        $inscritos2 = Inscritos::where('cursos_id', $id)
            ->where('estudiante_id', auth()->user()->id)
            ->first();


        $boletin = $inscritos2 ? Boletin::where('inscripcion_id', $inscritos2->id)->first() : null;

        // Generar el token y el código QR
        $token = $this->qrTokenService->generarToken($id);
        $urlInscripcion = route('inscribirse.qr', ['id' => $id, 'token' => $token->token]);
        $qrCode = $this->qrTokenService->generarQrCode($urlInscripcion);

        // Procesar descripciones de recursos
        foreach ($recursos as $recurso) {
            $recurso->descripcionRecursos = TextHelper::createClickableLinksAndPreviews($recurso->descripcionRecursos);
        }

        $tiposActividades = TipoActividad::all();


        return view('Cursos', [
            'foros' => $foros,
            'recursos' => $recursos,
            'temas' => $temas,
            'cursos' => $cursos,
            'tiposActividades' => $tiposActividades,
            'inscritos' => $inscritos,
            'inscritos2' => $inscritos2,
            'boletin' => $boletin,
            'horarios' => $horarios,
            'qrCode' => $qrCode,
            'template' => $certificado_template,
        ]);
    }



    public function listaCurso($id)
    {
        $cursos = Cursos::findOrFail($id);
        $inscritos = Inscritos::where('cursos_id', $id)->whereNull('deleted_at')->get();
        // ["cursos"=>$cursos]
        return view('ListaParticipantes')->with('inscritos', $inscritos)->with('cursos', $cursos);
    }

    public function imprimir($id)
    {
        $curso = Cursos::findOrFail($id);
        $inscritos = Inscritos::where('cursos_id', $id)->whereNull('deleted_at')->get();
        $horarios = Cursos_Horario::where('curso_id', $id)->get();
        return view('Estudiante.listadeestudiantes')->with('inscritos', $inscritos)->with('curso', $curso)->with('horarios', $horarios);
    }


    public function listaRetirados($id)
    {
        $cursos = Cursos::findOrFail($id);
        $inscritos = Inscritos::where('cursos_id', $id)->onlyTrashed()->get();
        // ["cursos"=>$cursos]
        return view('ListaParticipantesRetirados')->with('inscritos', $inscritos)->with('cursos', $cursos);
    }


    public function EditCIndex($id)
    {

        $cursos = Cursos::findOrFail($id);
        $docente = User::role('Docente')->get();
        $horario = Horario::all();

        return view('Administrador.EditarCursos')->with('docente', $docente)->with('horario', $horario)->with('cursos', $cursos);
    }
    public function EditC($id, Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_ini',
            'formato' => 'required|in:Presencial,Virtual,Híbrido',
            'tipo' => 'required|in:curso,congreso',
            'nota' => 'nullable|numeric|min:0|max:100',
            'archivo' => 'nullable|file|max:20480', // 20MB max
            'docente_id' => $user->hasRole('Administrador') ? 'required|exists:users,id' : '',
        ]);

        $curso = Cursos::findOrFail($id);

        $curso->nombreCurso = $request->nombre;
        $curso->descripcionC = $request->descripcion ?? '';
        $curso->formato = $request->formato;
        $curso->tipo = $request->tipo;
        $curso->notaAprobacion = $request->nota;
        $curso->edad_dirigida = $request->edad_id;
        $curso->nivel = $request->nivel_id;

        // Manejo de fechas
        $fecha_ini = Carbon::parse($request->fecha_ini)->format('Y-m-d H:i:s');
        $fecha_fin = $request->tipo === 'congreso'
            ? Carbon::parse($request->fecha_ini)->endOfDay()->format('Y-m-d H:i:s')
            : Carbon::parse($request->fecha_fin)->format('Y-m-d H:i:s');

        $curso->fecha_ini = $fecha_ini;
        $curso->fecha_fin = $fecha_fin;

        $curso->estado = ($fecha_fin < now()) ? 'Expirado' : 'Activo';

        // Asignar docente según rol
        if ($user->hasRole('Administrador')) {
            $curso->docente_id = $request->docente_id;
        } else {
            $curso->docente_id = $user->id;
        }

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            if ($curso->archivoContenidodelCurso) {
                Storage::delete('public/' . $curso->archivoContenidodelCurso);
            }

            $cursoArchivo = $request->file('archivo')->store('ArchivoCurso', 'public');
            $curso->archivoContenidodelCurso = $cursoArchivo;
        }

        $curso->updated_at = now();
        event(new CursoEvent($curso, 'modificado'));
        $curso->save();

        return back()->with('success', 'El curso ha sido editado correctamente');
    }


    public function eliminarCurso($id)
    {

        $cursos = Cursos::findOrFail($id);
        event(new CursoEvent($cursos, 'borrado'));

        $cursos->delete();

        return redirect(route('Inicio'))->with('success', 'Cursos elimnado Correctamante');
    }


    public function ReporteAsistencia($id)
    {
        $asistencias = Asistencia::where('curso_id', $id)->get();

        $writer = SimpleExcelWriter::streamDownload('report.xlsx');

        $writer->addRow(['Curso', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Fecha', 'Tipo Asistencia']);

        foreach ($asistencias as $asistencia) {
            $writer->addRow([$asistencia->cursos->nombreCurso, $asistencia->inscritos->estudiantes->name, $asistencia->inscritos->estudiantes->lastname1, $asistencia->inscritos->estudiantes->lastname2, $asistencia->fechaasistencia, $asistencia->tipoAsitencia]);
        }



        $writer->toBrowser();
    }
    public function ReporteFinal($id)
    {
        // Obtener asistencias
        $asistencias = Asistencia::where('curso_id', $id)->get();

        // Obtener notas de tareas filtradas por curso
        $notasTareas = NotaEntrega::whereHas('tarea.subtema.tema', function ($query) use ($id) {
            $query->where('curso_id', $id);
        })->get();

        // Obtener notas de evaluaciones filtradas por curso
        $notasEvaluaciones = NotaEvaluacion::whereHas('evaluacion', function ($query) use ($id) {
            $query->where('cursos_id', $id);
        })->get();

        // Obtener inscritos en el curso
        $inscritos = Inscritos::where('cursos_id', $id)->get();

        // Inicializa el escritor de Excel
        $writer = SimpleExcelWriter::streamDownload('report_final.xlsx');

        // Hoja de Asistencias
        $asistenciasSheet = $writer->addNewSheetAndMakeItCurrent('Asistencias');
        $asistenciasSheet->addRow(['Curso', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'Fecha', 'Tipo Asistencia']);

        foreach ($asistencias as $asistencia) {
            $asistenciasSheet->addRow([
                $asistencia->cursos->nombreCurso,
                $asistencia->inscritos->estudiantes->name,
                $asistencia->inscritos->estudiantes->lastname1,
                $asistencia->inscritos->estudiantes->lastname2,
                $asistencia->fechaasistencia,
                $asistencia->tipoAsitencia
            ]);
        }

        // Hoja de Tareas
        $tareasSheet = $writer->addNewSheetAndMakeItCurrent('Tareas');
        $tareasSheet->addRow(['Nombre Tarea', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'NOTA', 'RETROALIMENTACION']);

        foreach ($notasTareas as $notaTarea) {
            $tareasSheet->addRow([
                $notaTarea->tarea->titulo_tarea,
                $notaTarea->inscripcion->estudiantes->name,
                $notaTarea->inscripcion->estudiantes->lastname1,
                $notaTarea->inscripcion->estudiantes->lastname2,
                $notaTarea->nota,
                $notaTarea->retroalimentacion
            ]);
        }

        // Hoja de Evaluaciones
        $evaluacionesSheet = $writer->addNewSheetAndMakeItCurrent('Evaluaciones');
        $evaluacionesSheet->addRow(['Nombre Evaluación', 'Nombre', 'Apellido Paterno', 'Apellido Materno', 'NOTA', 'RETROALIMENTACION']);

        foreach ($notasEvaluaciones as $notaEvaluacion) {
            $evaluacionesSheet->addRow([
                $notaEvaluacion->evaluacion->titulo_evaluacion,
                $notaEvaluacion->inscripcion->estudiantes->name,
                $notaEvaluacion->inscripcion->estudiantes->lastname1,
                $notaEvaluacion->inscripcion->estudiantes->lastname2,
                $notaEvaluacion->nota,
                $notaEvaluacion->retroalimentacion
            ]);
        }

        // Hoja de Promedio Final
        $promfinalSheet = $writer->addNewSheetAndMakeItCurrent('PromedioFinal');
        $promfinalSheet->addRow(['Nombre', 'Apellido Paterno', 'Apellido Materno', 'NOTA PROMEDIO TAREAS', 'NOTA PROMEDIO EVALUACIONES', 'PROMEDIO FINAL']);

        foreach ($inscritos as $inscrito) {
            // Calcular promedio de tareas
            $promedioTareas = $inscrito->notatarea()
                ->whereHas('tarea.subtema.tema', function ($query) use ($id) {
                    $query->where('curso_id', $id);
                })
                ->avg('nota');

            // Calcular promedio de evaluaciones
            $promedioEvaluaciones = $inscrito->notaevaluacion()
                ->whereHas('evaluacion', function ($query) use ($id) {
                    $query->where('cursos_id', $id);
                })
                ->avg('nota');

            // Calcular promedio final
            $promedioFinal = ($promedioTareas + $promedioEvaluaciones) / 2;

            $promfinalSheet->addRow([
                $inscrito->estudiantes->name,
                $inscrito->estudiantes->lastname1,
                $inscrito->estudiantes->lastname2,
                round($promedioTareas, 2), // Redondear a 2 decimales
                round($promedioEvaluaciones, 2), // Redondear a 2 decimales
                round($promedioFinal, 2), // Redondear a 2 decimales
            ]);
        }

        // Descarga el archivo
        $writer->toBrowser();
    }


    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'precio' => 'required|numeric|min:0',
            'es_publico' => 'required|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Buscar el curso a actualizar
        $curso = Cursos::findOrFail($id);

        // Actualizar los campos básicos
        $curso->precio = $request->precio;
        $curso->es_publico = $request->es_publico;

        // Manejar la imagen si se subió una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($curso->imagen) {
                Storage::delete('public/' . $curso->imagen);
            }

            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('cursos', 'public');
            $curso->imagen = $imagenPath;
        }

        // Guardar los cambios
        $curso->save();

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Curso actualizado correctamente');
    }

    public function restaurarCurso($id)
    {

        $cursoEliminado = Cursos::onlyTrashed()->find($id);
        event(new CursoEvent($cursoEliminado, 'restaurado'));

        $cursoEliminado->restore();

        return back()->with('success', 'Curso restaurado correctamente');
    }

    public function ReporteFinalCurso($id)
    {


        $cursos = Cursos::findorFail($id);

        $asistencias = Asistencia::where('curso_id', $id)->get();

        $temas = Tema::where('curso_id', $id)->with(['subtemas.tareas', 'subtemas.cuestionarios'])->get();

        $evaluaciones = Evaluaciones::where('cursos_id', $id)->get();
        $asistencias = Asistencia::where('curso_id', $id)->get();
        $foros = Foro::where('cursos_id', $id)->get();
        $recursos = Recursos::where('cursos_id', $id)->get();

        $notasTareas = NotaEntrega::all(); // Filtra las notas de tareas por curso

        $notasEvaluaciones = NotaEvaluacion::all();


        $inscritos = Inscritos::where('cursos_id', $id)->get();



        $notasEvaluacion = NotaEvaluacion::where('inscripcion_id', $id)->get();
        $notasTareas = NotaEntrega::where('inscripcion_id', $id)->get();


        // Inicializa el contador para cada categoría
        $participanteCount = 0;
        $aprendizCount = 0;
        $habilidosoCount = 0;
        $expertoCount = 0;


        foreach ($inscritos as $inscrito) {
            $promedioNotas = ($inscrito->notatarea->avg('nota') + $inscrito->notaevaluacion->avg('nota')) / 2;

            if ($promedioNotas <= 51) {
                $participanteCount++;
            } elseif ($promedioNotas <= 65) {
                $aprendizCount++;
            } elseif ($promedioNotas <= 75) {
                $habilidosoCount++;
            } elseif ($promedioNotas <= 100) {
                $expertoCount++;
            }
        }

        // Contar la cantidad de cada tipo de asistencia

        $conteoPresentes = $asistencias->where('tipoAsitencia', 'Presente')->count();
        $conteoRetrasos = $asistencias->where('tipoAsitencia', 'Retraso')->count();
        $conteoFaltas = $asistencias->where('tipoAsitencia', 'Falta')->count();
        $conteoLicencias = $asistencias->where('tipoAsitencia', 'Licencia')->count();


        return view('Cursos.SumarioCurso', compact('conteoPresentes', 'conteoRetrasos', 'conteoFaltas', 'conteoLicencias', 'participanteCount', 'aprendizCount', 'habilidosoCount', 'expertoCount'))
            ->with('cursos', $cursos)->with('asistencias', $asistencias)
            ->with('inscritos', $inscritos)
            ->with('foros', $foros)
            ->with('recursos', $recursos)
            ->with('temas', $temas)
            ->with('evaluaciones', $evaluaciones);
    }

    public function activarCertificados($id)
    {
        $curso = Cursos::findOrFail($id);

        // Si la fecha de finalización ya pasó, no permitir activación
        if (now()->greaterThan(Carbon::parse($curso->fecha_fin)->endOfDay())) {
            return back()->with('error', 'El periodo para obtener certificados ha expirado.');
        }

        // Cambiar el estado a "Certificado Disponible"
        $curso->estado = 'Certificado Disponible';
        $curso->save();

        return back()->with('success', 'Certificados activados correctamente.');
    }
}
