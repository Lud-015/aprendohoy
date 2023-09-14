<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Foro;
use App\Models\ForoMensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForoController extends Controller
{

    public function Crearforo($id){

        $cursos = Cursos::findOrFail($id);

        return(view('Docente.CrearForo', compact('cursos', $cursos)));


    }

    public function store(Request $request){

        $request->validate([
            'nombreForo' => 'required',
            'descripcionForo' => 'required',
            'fechaFin' => 'required',
        ]);

        $foro = new Foro();

        $foro->nombreForo = $request->nombreForo;
        $foro->descripcionForo = $request->descripcionForo;
        $foro->fechaFin = date("Y-m-d", strtotime($request->fechaFin));
        $foro->cursos_id = $request->curso_id;
        $foro->created_at = now();
        $foro->save();

        return redirect(route('Inicio'));


    }
    public function index($id){
        $foro = Foro::findOrFail($id);
        $forosmensajes = ForoMensaje::all();


        return view('Foro', compact('foro', $foro), compact('forosmensajes', $forosmensajes));

    }


    public function storeMensaje(Request $request){

        $request->validate([
            'tituloMensaje' => 'required',
            'mensaje' => 'required',
        ]);

        $ForoMensaje = new ForoMensaje();

        $ForoMensaje->tituloMensaje = $request->tituloMensaje;
        $ForoMensaje->mensaje = $request->mensaje;
        $ForoMensaje->foro_id = $request->foro_id;
        $ForoMensaje->estudiante_id = $request->estudiante_id;

        $ForoMensaje->save();

        return back();

    }



    public function EditarForoIndex($id){

        $foro = Foro::findOrFail($id);

        return view('Docente.EditarForo', compact('foro', $foro));

    }
}
