<?php

namespace App\Http\Controllers;

use App\Events\ForoEvent;
use App\Models\Cursos;
use App\Models\Foro;
use App\Models\ForoMensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForoController extends Controller
{

    public function Crearforo($id){

        $cursos = Cursos::findOrFail($id);

        return(view('Docente.CrearForo'))->with('cursos', $cursos);


    }

    public function store(Request $request){

        $messages = [
            'nombreForo.required' => 'El campo nombre del foro es obligatorio.',
            'descripcionForo.required' => 'El campo descripción del foro es obligatorio.',
            'fechaFin.required' => 'El campo fecha de fin es obligatorio.',
        ];

        $request->validate([
            'nombreForo' => 'required',
            'descripcionForo' => 'required',
            'fechaFin' => 'required',
        ], $messages);

        $foro = new Foro();

        $foro->nombreForo = $request->nombreForo;
        $foro->descripcionForo = $request->descripcionForo;
        $foro->SubtituloForo = $request->SubtituloForo;
        $foro->fechaFin = date("Y-m-d", strtotime($request->fechaFin));
        $foro->cursos_id = $request->curso_id;
        $foro->created_at = now();
        event(new ForoEvent($foro, 'crear'));
        $foro->save();

        return redirect(route('Curso', $request->curso_id))->with('success', 'Foro Creado Correctamente');


    }
    public function index($id){
        $foro = Foro::findOrFail($id);
        $forosmensajes = ForoMensaje::where('foro_id', $foro->id)
            ->whereNull('respuesta_a')
            ->with('respuestas.estudiantes') // Cargar respuestas y sus autores
            ->get();


        return view('Foro')->with('foro', $foro)->with('forosmensajes', $forosmensajes);

    }


    public function storeMensaje(Request $request)
    {
        $messages = [
            'tituloMensaje.required' => 'El campo título del mensaje es obligatorio.',
            'mensaje.required' => 'El campo mensaje es obligatorio.',
            'foro_id.required' => 'El foro al que pertenece el mensaje es obligatorio.',
            'foro_id.exists' => 'El foro especificado no existe.',
            'estudiante_id.required' => 'El identificador del estudiante es obligatorio.',
            'estudiante_id.exists' => 'El estudiante especificado no existe.',
            'respuesta_a.exists' => 'El mensaje al que respondes no existe.',
        ];

        $validated = $request->validate([
            'tituloMensaje' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'foro_id' => 'required|exists:foros,id',
            'estudiante_id' => 'required|exists:users,id',
            'respuesta_a' => 'nullable|exists:foros_mensajes,id',
        ], $messages);

        try {
            $mensaje = ForoMensaje::create($validated);
            return back()->with('success', 'Mensaje enviado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error creating mensaje: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al enviar el mensaje. Inténtalo nuevamente.');
        }
    }




    public function EditarForoIndex($id){

        $foro = Foro::findOrFail($id);

        return view('Docente.EditarForo')->with('foro', $foro);

    }

    public function update(Request $request){

        $messages = [
            'nombreForo.required' => 'El campo nombre del foro es obligatorio.',
            'descripcionForo.required' => 'El campo descripción del foro es obligatorio.',
            'fechaFin.required' => 'El campo fecha de fin es obligatorio.',
        ];

        $request->validate([
            'nombreForo' => 'required',
            'descripcionForo' => 'required',
            'fechaFin' => 'required',
        ], $messages);


        $foro = Foro::findOrFail($request->idForo);

        $foro->nombreForo = $request->nombreForo;
        $foro->descripcionForo = $request->descripcionForo;
        $foro->SubtituloForo = $request->SubtituloForo;
        $foro->fechaFin = date("Y-m-d", strtotime($request->fechaFin));
        $foro->cursos_id = $request->curso_id;

        $foro->save();



        return redirect(route('Curso', $request->curso_id))->with('success', 'Foro editado correctamente');

    }





    public function indexE($id){


        $cursos = Cursos::findOrFail($id);

        $foro = Foro::withTrashed()
        ->where('cursos_id', $id)
        ->onlyTrashed()
        ->get();


        return view('Docente.ListaForosEliminados')->with('foro', $foro)->with('cursos', $cursos);






    }



    public function restore($id)
    {
        $foro = Foro::onlyTrashed()->find($id);
        $foro->restore();

        return back()->with('succes', 'Foro restaurado exitosamente');

    }

    public function editMensaje(Request $request, $id)
{
    $mensaje = ForoMensaje::findOrFail($id);

    $messages = [
        'tituloMensaje.required' => 'El campo título del mensaje es obligatorio.',
        'mensaje.required' => 'El campo mensaje es obligatorio.',
    ];

    $request->validate([
        'tituloMensaje' => 'required',
        'mensaje' => 'required',
    ], $messages);

    $mensaje->update([
        'tituloMensaje' => $request->tituloMensaje,
        'mensaje' => $request->mensaje,
    ]);

    return back()->with('success', 'Mensaje actualizado correctamente.');
}

public function editRespuesta(Request $request, $id)
{
    $respuesta = ForoMensaje::findOrFail($id); // Encuentra la respuesta

    $messages = [
        'tituloMensaje.required' => 'El campo título de la respuesta es obligatorio.',
        'mensaje.required' => 'El campo mensaje es obligatorio.',
    ];

    $request->validate([
        'tituloMensaje' => 'required',
        'mensaje' => 'required',
    ], $messages);

    $respuesta->update([
        'tituloMensaje' => $request->tituloMensaje,
        'mensaje' => $request->mensaje,
    ]);

    return back()->with('success', 'Respuesta actualizada correctamente.');
}

public function deleteRespuesta($id)
{
    $respuesta = ForoMensaje::findOrFail($id);
    $respuesta->delete(); // Soft delete
    return back()->with('success', 'Respuesta eliminada correctamente.');
}


public function deleteMensaje($id)
{
    $mensaje = ForoMensaje::findOrFail($id);
    $mensaje->delete(); // Soft delete
    return back()->with('success', 'Mensaje eliminado correctamente.');
}







    public function delete($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->delete();

        return back()->with('success', 'Foro eliminado exitosamente.');
    }
}
