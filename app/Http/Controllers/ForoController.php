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
        $forosmensajes = ForoMensaje::all();


        return view('Foro')->with('foro', $foro)->with('forosmensajes', $forosmensajes);

    }


    public function storeMensaje(Request $request){

        $messages = [
            'tituloMensaje.required' => 'El campo título del mensaje es obligatorio.',
            'mensaje.required' => 'El campo mensaje es obligatorio.',
        ];

        $request->validate([
            'tituloMensaje' => 'required',
            'mensaje' => 'required',
        ], $messages);

        $ForoMensaje = new ForoMensaje();

        $ForoMensaje->tituloMensaje = $request->tituloMensaje;
        $ForoMensaje->mensaje = $request->mensaje;
        $ForoMensaje->foro_id = $request->foro_id;
        $ForoMensaje->estudiante_id = $request->estudiante_id;

        $ForoMensaje->save();

        return back()->with('success', 'Mensaje Enviado');

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







    public function delete($id)
    {
        $foro = Foro::findOrFail($id);
        $foro->delete();

        return back()->with('success', 'Foro eliminado exitosamente.');
    }
}
