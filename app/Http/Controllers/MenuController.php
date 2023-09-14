<?php

namespace App\Http\Controllers;

use App\Models\EdadDirigida;
use App\Models\Horario;
use App\Models\Nivel;
use App\Models\User;
use App\Models\Cursos;
use App\Models\Inscritos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){

    $cursos = Cursos::all();
    $inscritos = Inscritos::all();
    return view('Inicio',  compact('cursos'), compact('inscritos'));


    }

    public function ListaDeCursos(){
        return view('ListadeCursos');
    }




    public function ListaDocentes()
    {
    $docente = User::role('Docente')->get();
    return view('Administrador.ListadeDocentes')->with('docente', $docente);
    }


    public function ListaEstudiantes()
    {
    $estudiantes = User::role('Estudiante')->get();

    return view('Administrador.ListadeEstudiantes')->with('estudiantes', $estudiantes);
    }



    public function storeDIndex()
    {
    return view('Administrador.CrearDocente');
    }
    public function storeETIndex()
    {
    return view('Administrador.CrearEstudianteConTutor');
    }
    public function storeEIndex()
    {
    return view('Administrador.CrearEstudiante');
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
