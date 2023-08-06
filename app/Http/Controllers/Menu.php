<?php

namespace App\Http\Controllers;

use App\Models\EdadDirigida;
use App\Models\Horario;
use App\Models\Nivel;
use App\Models\User;
use App\Models\Cursos;
use Illuminate\Http\Request;

class Menu extends Controller
{
    public function index(){
    
    $cursos = Cursos::all();    
    return view('Inicio',  compact('cursos'));
    

    }
    
    public function ListaDeCursos(){
        return view('ListadeCursos');   
    }    
    public function ListaDocentes()
    {
    $docente = User::role('Docente')->get();
    return view('Administrador.ListadeDocentes')->with('docente', $docente);
    }
    public function storeDIndex()
    {   
    return view('Administrador.CrearDocente');
    }
    public function ListaCursos()
    {

    $cursos = Cursos::all();    
    return view('Administrador.ListadeCursos', compact('cursos'));
    
    }

    public function storeCIndex()
    {

    $niveles = Nivel::all();
    $edad = EdadDirigida::all();
    $docente = User::role('Docente')->get();
    $horario = Horario::all();

    return view('Administrador.CrearCursos')->with('docente', $docente)->with('horario', $horario)->with('edad', $edad)->with('niveles', $niveles);


    }

}
