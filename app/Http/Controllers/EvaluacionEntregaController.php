<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionEntrega;
use Illuminate\Http\Request;

class EvaluacionEntregaController extends Controller
{

    public function store(Request $request)
    {
        $request -> validate([
            'entrega' => 'required'
        ]);

        $entrega = new EvaluacionEntrega();

        $entrega->estudiante_id = $request->estudiante_id;
        $entrega->evaluacion_id = $request->evaluacion_id;

        if ($request->hasFile('entrega')) {
            $tareaEntrega = $request->file('entrega')->store('entrega', 'public');
            $entrega->ArchivoEntrega = $tareaEntrega;
        }

        $entrega ->save();

        return back()->with('success', 'Tarea subida correctamente');

    }

    public function delete($id)
    {

        $entrega = EvaluacionEntrega::find($id);
        $entrega ->delete();
        return back()->with('success', 'Tarea eliminada correctamente');;

    }
}
