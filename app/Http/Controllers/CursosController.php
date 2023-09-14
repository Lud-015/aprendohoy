<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\EdadDirigida;
use App\Models\Foro;
use App\Models\Horario;
use App\Models\Inscritos;
use App\Models\Nivel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $cursos = Cursos::findOrFail($id);

        $inscritos = DB::table('inscritos')->where('cursos_id', $id)->where('estudiante_id', auth()->user()->id)->get();
        $foros = DB::table('foros')->where('cursos_id', $id)->get();
        // ["cursos"=>$cursos]
        return view('Cursos', compact('cursos', $cursos), compact('inscritos', $inscritos))->with('foros', $foros);



    }



    public function listaCurso($id)
    {
        $cursos = Cursos::findOrFail($id);
        $inscritos = Inscritos::all();
        // ["cursos"=>$cursos]
        return view('ListaParticipantes', compact('cursos', $cursos), compact('inscritos'));
    }

    public function EditCIndex($id)
    {

    $cursos= Cursos::findOrFail($id);
    $niveles = Nivel::all();
    $edad = EdadDirigida::all();
    $docente = User::role('Docente')->get();
    $horario = Horario::all();

    return view('Administrador.EditarCursos')->with('docente', $docente)->with('horario', $horario)->with('edad', $edad)->with('niveles', $niveles)->with('cursos', $cursos);


    }
    public function EditC($id, Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
            'formato' => 'required',

        ]);


        $curso = Cursos::findOrFail($id);
        $curso->nombreCurso = $request->nombre;
        $curso->descripcionC = $request->descripcion;
        $curso->fecha_ini = date("Y-m-d", strtotime($request->fecha_ini));
        $curso->fecha_fin = date("Y-m-d", strtotime($request->fecha_fin));
        $curso->formato = $request->formato;
        $curso->docente_id = $request->docente_id ;
        $curso->edadDir_id = $request->edad_id;
        $curso->niveles_id = $request->nivel_id;
        $curso->horario_id = $request->horario_id;
        $curso->updated_at = now();

        $curso->save();

        return redirect(route('Inicio'));

    }



}
