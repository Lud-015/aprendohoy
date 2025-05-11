<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\ActividadCompletion;
use App\Models\EntregaArchivo;
use App\Models\IntentoCuestionario;
use App\Models\Cuestionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{


    public function completarActividad(Request $request, $actividadId)
    {
        $request->validate([
            'inscritos_id' => 'required|exists:inscritos,id',
        ]);

        ActividadCompletion::updateOrCreate(
            [
                'completable_type' => Actividad::class,
                'completable_id' => $actividadId,
                'inscritos_id' => $request->inscritos_id,
            ],
            [
                'completed' => true,
                'completed_at' => now(),
            ]
        );

        return back()->with('success', 'Actividad marcada como completada.');
    }

    public function ocultar($id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->update(['es_publica' => false]);

        return redirect()->back()->with('success', 'La actividad ha sido ocultada.');
    }

    public function mostrar($id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->update(['es_publica' => true]);

        return redirect()->back()->with('success', 'La actividad ahora es visible.');
    }

    public function store(Request $request, $cursoId)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'orden' => 'nullable|integer',
            'es_publica' => 'nullable|boolean',
            'es_obligatoria' => 'nullable|boolean',
            'subtema_id' => 'nullable|exists:subtemas,id', // Validar que el subtema exista
            'tipo_actividad_id' => 'required|exists:tipo_actividades,id', // Validar que el tipo de actividad exista
            'tipos_evaluacion' => 'required|array', // Validar que sea un array
            'tipos_evaluacion.*.tipo_evaluacion_id' => 'required|exists:tipo_evaluaciones,id', // Validar cada tipo de evaluación
            'tipos_evaluacion.*.puntaje_maximo' => 'required|integer|min:0', // Validar puntaje máximo
            'tipos_evaluacion.*.es_obligatorio' => 'required|boolean', // Validar si es obligatorio
        ]);


        $ordenMaximo = Actividad::where('subtema_id', $data['subtema_id'] ?? null)->max('orden');
        $data['orden'] = is_null($ordenMaximo) ? 1 : $ordenMaximo + 1;


        $actividad = Actividad::create($data);

        foreach ($data['tipos_evaluacion'] as $tipoEvaluacion) {
            DB::table('actividad_tipos_evaluacion')->insert([
                'actividad_id' => $actividad->id,
                'tipo_evaluacion_id' => $tipoEvaluacion['tipo_evaluacion_id'],
                'puntaje_maximo' => $tipoEvaluacion['puntaje_maximo'],
                'es_obligatorio' => $tipoEvaluacion['es_obligatorio'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }



        return redirect()->route('Curso', $cursoId)
            ->with('success', 'Actividad creada exitosamente.');
    }


    public function update(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'tipo_actividad_id' => 'required|exists:tipo_actividades,id',
            'tipos_evaluacion' => 'required|array',
            'tipos_evaluacion.*.tipo_evaluacion_id' => 'required|exists:tipo_evaluaciones,id',
            'tipos_evaluacion.*.puntaje_maximo' => 'required|integer|min:0',
            'tipos_evaluacion.*.es_obligatorio' => 'required|boolean',
        ]);

        $actividad->update([
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_limite' => $data['fecha_limite'],
            'tipo_actividad_id' => $data['tipo_actividad_id'],
        ]);

        // Actualizar los tipos de evaluación
        $actividad->tiposEvaluacion()->sync([]);
        foreach ($data['tipos_evaluacion'] as $tipoEvaluacion) {
            $actividad->tiposEvaluacion()->attach($tipoEvaluacion['tipo_evaluacion_id'], [
                'puntaje_maximo' => $tipoEvaluacion['puntaje_maximo'],
                'es_obligatorio' => $tipoEvaluacion['es_obligatorio'],
            ]);
        }

        return redirect()->back()->with('success', 'Actividad actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->delete();

        return back()->with('success', 'Actividad eliminada correctamente.');
    }

    public function restaurar($id)
    {
        $actividad = Actividad::withTrashed()->findOrFail($id);

        if ($actividad->trashed()) {
            // Restaurar
            $actividad->restore();

            // Reasignar orden al final
            $ordenMaximo = Actividad::where('subtema_id', $actividad->subtema_id)
                ->whereNull('deleted_at')
                ->max('orden');

            $actividad->orden = is_null($ordenMaximo) ? 1 : $ordenMaximo + 1;
            $actividad->save();

            return back()->with('success', 'Actividad restaurada exitosamente.');
        }

        return back()->with('error', 'La actividad no está eliminada.');
    }
}
