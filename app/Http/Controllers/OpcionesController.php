<?php

namespace App\Http\Controllers;

use App\Models\Opcion;
use Illuminate\Http\Request;

class OpcionesController extends Controller
{
    public function store(Request $request, $id){

        $request->validate([
            'respuesta' => 'required|string|max:255',
            'es_correcta' => 'required|boolean',
        ], [
            'pregunta.required' => 'La Respuesta es obligatoria.',
            'pregunta.string' => 'La pregunta debe ser una cadena de texto.',
            'pregunta.max' => 'La pregunta no debe superar los 255 caracteres.',
            'es_correcta.required' => 'La Respuesta es correcta o incorrecta.',
        ]);


        Opcion::create([
            'pregunta_id' => $id,
            'texto' => $request->respuesta,
            'es_correcta' => $request->es_correcta,
        ]);


        return back()->with('success', 'Pregunta creada correctamente.');


    }


    public function edit(Request $request, $id){
        $request->validate([
            'respuesta' => 'required|string|max:255',
            'es_correcta' => 'required|boolean',
        ], [
            'pregunta.required' => 'La Respuesta es obligatoria.',
            'pregunta.string' => 'La pregunta debe ser una cadena de texto.',
            'pregunta.max' => 'La pregunta no debe superar los 255 caracteres.',
            'es_correcta.required' => 'La Respuesta es correcta o incorrecta.',
        ]);

        $opcion = Opcion::findOrFail($id);
        $opcion->update([
            'texto' => $request->respuesta,
            'es_correcta' => $request->es_correcta,
        ]);


        return back()->with('success', 'Respuesta editada correctamente.');

    }

    public function delete($id){
        $opcion = Opcion::findOrFail($id);
        $opcion->delete();
        return back()->with('success', 'Respuesta eliminada correctamente.');

    }
    public function restore($id)
    {
        $opcion = Opcion::onlyTrashed()->findOrFail($id);
        $opcion->restore();
        return back()->with('success', 'Pregunta restaurada correctamente.');
    }
}
