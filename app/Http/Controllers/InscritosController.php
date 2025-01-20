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

class InscritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $estudiantes = User::role('Estudiante')->get();
        $cursos = Cursos::where('fecha_fin', '>=', now())->get();
        $inscritos = Inscritos::all();

        # code...

        return (view('Administrador.AsignarCursos')->with('estudiantes', $estudiantes)->with('cursos', $cursos));



    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar que 'estudiantes' es un array y 'curso' es requerido
        $request->validate([
            'estudiantes' => 'required|array',
            'curso' => 'required|exists:cursos,id',
        ]);

        $cursoId = $request->curso;
        $estudiantes = $request->estudiantes;

        // Verificar si alguno de los estudiantes ya está inscrito
        $estudiantesConInscripcion = Inscritos::whereIn('estudiante_id', $estudiantes)
            ->where('cursos_id', $cursoId)
            ->withTrashed()
            ->pluck('estudiante_id')
            ->toArray();

        if (!empty($estudiantesConInscripcion)) {
            // Obtener los nombres de los estudiantes que ya están inscritos
            $nombresEstudiantes = User::whereIn('id', $estudiantesConInscripcion)
                ->pluck('name')
                ->toArray();

            // Redirigir con un error si uno o más estudiantes ya están inscritos
            return redirect()->route('AsignarCurso')->withErrors([
                'msg' => 'Uno o más estudiantes ya están asignados a este curso: ' . implode(', ', $nombresEstudiantes)
            ]);
        }

        // Usar una transacción para asegurar la atomicidad
        \DB::transaction(function () use ($estudiantes, $cursoId) {
            foreach ($estudiantes as $estudianteId) {
                // Crear una nueva inscripción
                $inscribir = new Inscritos();
                $inscribir->estudiante_id = $estudianteId;
                $inscribir->cursos_id = $cursoId;
                $inscribir->created_at = now();

                // Guardar la inscripción
                $inscribir->save();

                // Obtener el objeto Estudiante
                $estudiante = User::find($estudianteId);

                // Obtener el objeto Curso
                $curso = Cursos::find($cursoId);

                if ($estudiante && $curso) {
                    // Enviar la notificación a través del evento
                    event(new InscritoEvent($estudiante, $curso, 'inscripcion'));
                }
            }
        });

        return back()->with('success', 'Estudiantes inscritos exitosamente!');
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
}
