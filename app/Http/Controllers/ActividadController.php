<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\EntregaArchivo;
use App\Models\IntentoCuestionario;
use App\Models\Cuestionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{


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
        ]);

        // Buscar el orden máximo actual para el mismo subtema (o general si no usas subtemas)
        $ordenMaximo = Actividad::where('subtema_id', $data['subtema_id'] ?? null)->max('orden');

        // Si no hay actividades previas, empieza desde 1
        $data['orden'] = is_null($ordenMaximo) ? 1 : $ordenMaximo + 1;


        $actividad = Actividad::create($data);

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
            'orden' => 'nullable|integer',
            'es_publica' => 'nullable|boolean',
            'es_obligatoria' => 'nullable|boolean',
            'subtema_id' => 'nullable|exists:subtemas,id', // Validar que el subtema exista
            'tipo_actividad_id' => 'required|exists:tipo_actividades,id', // Validar que el tipo de actividad exista
        ]);

        $actividad->update($data);

        return back()->with('success', 'Actividad actualizada correctamente.');
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
