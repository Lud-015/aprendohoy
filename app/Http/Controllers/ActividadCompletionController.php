<?php

namespace App\Http\Controllers;

use App\Models\ActividadCompletion;
use App\Models\Cuestionario;
use App\Models\Inscritos;
use App\Models\Tareas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadCompletionController extends Controller
{
    // Marcar tarea como completada
    public function marcarTareaCompletada(Request $request, $tareaId)
    {

        $request->validate([
            'inscritos_id' => 'required' // Validar que el inscritos_id exista en la tabla inscritos
        ]);

        $tarea = Tareas::findOrFail($tareaId);

        $estudiante = User::findOrFail( $request->inscritos_id);
        $inscripcion = $estudiante->inscritos->where('cursos_id', $tarea->subtema->tema->curso->id)->first();



        if (!$inscripcion) {
            return redirect()->back()->with('error', 'No estás inscrito en este curso.');
        }



        ActividadCompletion::updateOrCreate(
            [
                'completable_type' => get_class($tarea),
                'completable_id' => $tarea->id,
                'inscritos_id' => $inscripcion->id,
            ],
            [
                'completed' => true,
                'completed_at' => now(),
            ]
        );


        return redirect()->back()->with('success', 'Tarea marcada como completada.');
    }

    // Marcar cuestionario como completado
    public function marcarCuestionarioCompletado(Request $request, $cuestionarioId)
    {
        $request->validate([
            'inscritos_id' => 'required|exists:inscritos,id'
        ]);

        $cuestionario = Cuestionario::findOrFail($cuestionarioId);



        ActividadCompletion::updateOrCreate(
            [
                'completable_type' => get_class($cuestionario),
                'completable_id' => $cuestionario->id,
                'inscritos_id' => $request->inscritos_id,
            ],
            [
                'completed' => true,
                'completed_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Cuestionario completado');
    }
}
