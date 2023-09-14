<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\Inscritos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class InscritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $estudiantes = User::role('Estudiante')->get();
        $cursos = Cursos::all();
        $inscritos = Inscritos::all();

            # code...

        return(view('Administrador.AsignarCursos')->with('estudiantes', $estudiantes)->with('cursos', $cursos));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'estudiante' => 'required',
        //     'curso' => 'required',

        // ]);

        $inscribir = new Inscritos();

        $inscribir->estudiante_id = $request->estudiante;
        $inscribir->cursos_id = $request->curso;
        $inscribir->created_at = now();




            if ((Inscritos::where('estudiante_id', $inscribir->estudiante_id)->where('cursos_id', $inscribir->cursos_id)->exists())) {

                return redirect()->route('AsignarCurso')->withErrors(['msg' => 'Alumno Ya Inscrito']);

            }else{


                $inscribir -> save();

                return redirect()->route('Inicio');
            }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function show(Inscritos $inscritos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscritos $inscritos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscritos $inscritos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscritos  $inscritos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscritos $inscritos)
    {
        //
    }
}
