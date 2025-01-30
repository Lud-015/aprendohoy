<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    public function store(Request $request, $id){

        $request->validate([
            'pregunta' => 'required|string|max:255',
            'tipo' => 'nullable|string',
            'puntos' => 'nullable|int',
        ], [
            'pregunta.required' => 'La pregunta es obligatoria.',
            'pregunta.string' => 'La pregunta debe ser una cadena de texto.',
            'pregunta.max' => 'La pregunta no debe superar los 255 caracteres.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'puntos.number' => 'Los puntos deben ser una cadena de texto.',
        ]);


        Pregunta::create([
            'cuestionario_id' => $id,
            'pregunta' => $request->pregunta,
            'tipo' => $request->tipo_preg,
            'puntos' => $request->puntos,
        ]);


        return back()->with('success', 'Pregunta creada correctamente.');


    }


    public function edit(Request $request, $id){
        $request->validate([
            'pregunta' => 'required|string|max:255',
            'tipo' => 'nullable|string',
            'puntos' => 'nullable|int',
        ], [
            'pregunta.required' => 'La pregunta es obligatoria.',
            'pregunta.string' => 'La pregunta debe ser una cadena de texto.',
            'pregunta.max' => 'La pregunta no debe superar los 255 caracteres.',
            'tipo.string' => 'El tipo debe ser una cadena de texto.',
            'puntos.number' => 'Los puntos deben ser una cadena de texto.',
        ]);

        $pregunta = Pregunta::findOrFail($id);


        $pregunta->update([
            'pregunta' => $request->pregunta,
            'tipo' => $request->tipo_preg,
            'puntos' => $request->puntos,
        ]);

        return back()->with('success', 'Pregunta editada correctamente.');

    }

    public function delete($id){
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->delete();
        return back()->with('success', 'Pregunta eliminada correctamente.');

    }
    public function restore($id)
    {
        $pregunta = Pregunta::onlyTrashed()->findOrFail($id); // Busca en los registros eliminados
        $pregunta->restore(); // Restaura la pregunta
        return back()->with('success', 'Pregunta restaurada correctamente.');
    }

}
