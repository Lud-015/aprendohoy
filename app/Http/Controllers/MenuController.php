<?php

namespace App\Http\Controllers;

use App\Models\Aportes;
use App\Models\Horario;
use App\Models\User;
use App\Models\Cursos;
use App\Models\Evaluaciones;
use App\Models\Foro;
use App\Models\Inscritos;
use App\Models\Tareas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{


    public function index(){

        $cursos2 = Cursos::whereNull('deleted_at')->get();
        $cursos = Cursos::whereNull('deleted_at')->get();
        $estudiantes = User::whereNull('deleted_at')->role('Estudiante')->get();
        $docentes = User::whereNull('deleted_at')->role('Docente')->get();
        $inscritos = Inscritos::whereNull('deleted_at')->get();
        return view('Inicio')->with('cursos2', $cursos2)->with('cursos', $cursos)->with('inscritos',$inscritos)->with('estudiantes',$estudiantes)->with('docentes',$docentes);


    }

    public function ListaDeCursos(){

    $cursos = Cursos::whereNull('deleted_at')->get();
    $inscritos = Inscritos::all();
    return view('ListaDeCursos')->with('cursos', $cursos)->with('inscritos',$inscritos);


    }

    public function ListaDeCursosEliminados(){

        $cursos = Cursos::onlyTrashed()->get();

        return view('Administrador.ListadeCursosEliminados')->with('cursos' ,$cursos);
    }




    public function ListaDocentes()
    {
    $docente = User::role('Docente')->get();
    return view('Administrador.ListadeDocentes')->with('docente', $docente);
    }
    public function ListaDocentesEliminados()
    {
    $docente = User::role('Docente')->onlyTrashed()->get();
    return view('Administrador.ListadeDocentesEliminados')->with('docente', $docente);
    }

    public function ListaAportes()
    {
    $aportes = Aportes::all();
    return view('Administrador.ListadeAportes')->with('aportes', $aportes);
    }


    public function ListaEstudiantes()
    {
    $estudiantes = User::role('Estudiante')->get();

    return view('Administrador.ListadeEstudiantes')->with('estudiantes', $estudiantes);
    }
    public function ListaEstudiantesEliminados()
    {
    $estudiantes = User::role('Estudiante')->onlyTrashed()->get();

    return view('Administrador.ListadeEstudiantesEliminados')->with('estudiantes', $estudiantes);
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

    $cursos = Cursos::whereNull('deleted_at')->get();

    return view('Inicio')->with('cursos', $cursos);

    }

    public function storeCIndex()
    {

    $docente = User::role('Docente')->get();
    $horario = Horario::all();

    return view('Administrador.CrearCursos')->with('docente', $docente)->with('horario', $horario);


    }

    public function calendario(){

        if (Auth::user()->hasRole('Docente')) {
            $cursos = Cursos::where('docente_id', Auth::user()->id)->get();
        } elseif (Auth::user()->hasRole('Estudiante')) {
            $inscripciones = Inscritos::where('estudiante_id', Auth::user()->id)->get();
            $cursos = Cursos::whereIn('id', $inscripciones->pluck('cursos_id'))->get();
        }

        $tareas = collect();
        $evaluaciones = collect();
        $foros = collect();

        foreach ($cursos as $curso) {
            $cursoTareas = Tareas::with(['subtema.tema'])
            ->whereHas('subtema.tema', function ($query) use ($curso) {
                $query->where('curso_id', $curso->id);
            })
            ->get();

            $cursoEvaluaciones = Evaluaciones::where('cursos_id', $curso->id)->get();
            $cursoForos = Foro::where('cursos_id', $curso->id)->get();

            $tareas = $tareas->merge($cursoTareas);
            $evaluaciones = $evaluaciones->merge($cursoEvaluaciones);
            $foros = $foros->merge($cursoForos);
        }

        return view('calendario', [
            'tareas' => $tareas,
            'foros' => $foros,
            'evaluaciones' => $evaluaciones,
            'cursos' => $cursos
        ]);
    }

    public function analytics(){
        $cursos2 = Cursos::whereNull('deleted_at')->get();

        return view('Docente.analitics')->with('cursos2', $cursos2);

    }

    public function quizz(){

        return view('quizzprueba');
    }






}
