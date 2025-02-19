<?php

namespace App\Http\Controllers;

use App\Events\InscritoEvent;
use App\Models\Cursos;
use App\Models\Inscritos;
use App\Models\User;
use App\Notifications\InscritoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class InscritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los estudiantes
        $estudiantes = User::role('Estudiante')->get();
        // Obtener todos los cursos activos
        $cursos = Cursos::where('fecha_fin', '>=', now())->get();

        // Obtener la lista de estudiantes inscritos en cada curso
        $inscritos = Inscritos::pluck('estudiante_id')->toArray();



        return view('Administrador.AsignarCursos', [
            'estudiantes' => $estudiantes,
            'cursos' => $cursos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validar los datos de entrada
        $request->validate([
            'curso_id' => [
                'required'
            ],
            'estudiante_id' => [
                'required'
            ]
        ], [
            'curso.required' => 'El campo curso es obligatorio.',
            'estudiante_id.required' => 'El campo estudiante es obligatorio.',
        ]);

        $cursoId = $request->curso_id;
        $estudianteId = $request->estudiante_id;


        // Verificar si el estudiante ya está inscrito en el curso
        if (Inscritos::where('cursos_id', $cursoId)->where('estudiante_id', $estudianteId)->exists()) {
            // Redirigir con un mensaje de error si ya está inscrito
            return back()->with('error','El estudiante ya está inscrito en este curso.');
        }

        // Crear una nueva inscripción
        $inscribir = new Inscritos();
        $inscribir->cursos_id = $cursoId;
        $inscribir->estudiante_id = $estudianteId;
        $inscribir->save();

        // Obtener el estudiante y el curso para la notificación
        $estudiante = User::find($estudianteId);
        $curso = Cursos::find($cursoId);

        // Disparar el evento de inscripción
        event(new InscritoEvent($estudiante, $curso, 'inscripcion'));

        // Redirigir con un mensaje de éxito
        return back()->with('success', 'Estudiante inscrito exitosamente!');
    }


    public function storeCongreso($id)
    {



        $cursoId = $id;
        $estudianteId = auth()->user()->id;


        // Verificar si el estudiante ya está inscrito en el curso
        if (Inscritos::where('cursos_id', $cursoId)->where('estudiante_id', $estudianteId)->exists()) {
            // Redirigir con un mensaje de error si ya está inscrito
            return back()->with('error','Ya estás inscrito en este curso.');
        }

        // Crear una nueva inscripción
        $inscribir = new Inscritos();
        $inscribir->cursos_id = $cursoId;
        $inscribir->estudiante_id = $estudianteId;
        $inscribir->save();

        // Obtener el estudiante y el curso para la notificación
        $estudiante = User::find($estudianteId);
        $curso = Cursos::find($cursoId);

        // Disparar el evento de inscripción
        event(new InscritoEvent($estudiante, $curso, 'inscripcion'));

        // Redirigir con un mensaje de éxito
        return back()->with('success', 'Estudiante inscrito exitosamente!');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $inscritos = Inscritos::find($id);


        event(new InscritoEvent($inscritos->estudiantes, $inscritos->cursos, 'eliminacion'));

        $inscritos->delete();

        return back()->with('success', 'Inscripcion retirada');
    }


    public function restaurarInscrito($id)
    {
        $inscritos = Inscritos::onlyTrashed()->find($id);


        event(new InscritoEvent($inscritos->estudiantes, $inscritos->cursos, 'restauracion'));


        $inscritos->restore();

        return back()->with('success', 'Inscripcion restaurada!');

    }

    public function completado($id){


        $inscritos = Inscritos::findOrFail( $id );

        if ($inscritos->cursos->docente_id == auth()->user()->id || auth()->user()->hasRole('administrador')) {
            $inscritos->completado = true;
            $inscritos->progreso = 100;

            $inscritos->save();

            return back()->with('success','El estudiante a completado el curso');
        }

        return abort(403);



    }


    public function inscribirse($id, $token)
    {
        $qrToken = DB::table('qr_tokens')
            ->where('curso_id', $id)
            ->where('token', $token)
            ->where('expiracion', '>=', now())
            ->whereColumn('usos_actuales', '<', 'limite_uso')
            ->first();

        if (!$qrToken) {
            return redirect()->route('Inicio')->withErrors('El código QR no es válido o ha expirado.');
        }

        DB::table('qr_tokens')->where('id', $qrToken->id)->increment('usos_actuales');

        $curso = Cursos::findorFail($id);

        if ($curso->fecha_fin) {
            $fechaActual = Carbon::now();
            $fechaFin = Carbon::parse($curso->fecha_fin);

            if ($fechaFin->lt($fechaActual)) {
                return redirect()->route('Inicio')->withErrors('El curso ya finalizó.');
            }
        }

        $usuario = auth()->user();
        if ($usuario->hasRole('Administrador') || $usuario->hasRole('Docente')) {
            return redirect()->route('Inicio')->with('errors' ,'No puedes inscribirte es este curso siendo docente o administrador porfavor crear otra cuenta.');
        }elseif ($usuario->id == $curso->docente_id) {
            return redirect()->route('Inicio')->withErrors('Ya eres Docente en este curso.');
        }

        $inscripcion = Inscritos::withTrashed() // Incluir registros eliminados
            ->where('cursos_id', $id)
            ->where('estudiante_id', $usuario->id)
            ->first();

        if ($inscripcion) {
            if ($inscripcion->trashed()) {
                return redirect()->back()->withErrors('Tu inscripción en este curso fue cancelada previamente.');
            }

            return redirect()->back()->withErrors('Ya estás inscrito en este curso.');
        }

        $estudiante = User::find($usuario->id);

        if ($estudiante && $curso) {
            // Enviar la notificación a través del evento
            event(new InscritoEvent($estudiante, $curso, 'inscripcion'));
        }

        $inscritos = new Inscritos();
        $inscritos->cursos_id = $id;
        if ($curso->tipo == 'congreso') {
            $inscritos->pago_completado = true;
            $inscritos->progreso = doubleval(100);
        }
        $inscritos->estudiante_id = $usuario->id;
        $inscritos->save();



        return redirect()->route('Curso', $id)->with('success', '¡Te has inscrito correctamente!');
    }


    public function actualizarPago(Request $request, $inscrito_id)
    {
        // Encuentra el registro de inscripción
        $inscrito = Inscritos::findOrFail($inscrito_id);

        // Actualiza el campo 'pago_completado' basado en el valor enviado desde el formulario
        $inscrito->pago_completado = filter_var($request->input('pago_completado'), FILTER_VALIDATE_BOOLEAN);
        $inscrito->save();

        // Redirige con un mensaje de éxito
        return redirect()->back()->with('success', 'El estado del pago se ha actualizado correctamente.');
    }







}
