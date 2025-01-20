<?php

namespace App\Http\Controllers;

use App\Events\RecursosEvent;
use App\Models\Cursos;
use App\Models\Recursos;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $curso = Cursos::findOrFail($id);
        return view('Docente.CrearRecursos')->with('curso', $curso);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'tituloRecurso.required' => 'El campo título del recurso es obligatorio.',
            'descripcionRecurso.required' => 'El campo descripción del recurso es obligatorio.',
            'tipoRecurso.required' => 'Elige un tipo de Recurso.',
        ];

        $request->validate([
            'tituloRecurso' => 'required',
            'descripcionRecurso' => 'required',
            'tipoRecurso' => 'required',
        ], $messages);

        $recurso = new Recursos();

        $recurso->nombreRecurso = $request->tituloRecurso;
        $recurso->cursos_id = $request->cursos_id;

        $recurso->descripcionRecursos = $request->descripcionRecurso;
        $recurso->tipoRecurso = $request->tipoRecurso;

        if ($request->hasFile('archivo')) {
            $recursosPath = $request->file('archivo')->store('archivo', 'public');
            $recurso->archivoRecurso = $recursosPath;
        }

        event(new RecursosEvent($recurso, 'crear'));

        $recurso->save();


        return redirect(route('Curso', $request->cursos_id))->with('success', 'Recurso creado Con éxito');

    }

    public function descargar($nombreArchivo)
    {
        $rutaArchivo = storage_path('/app/public/'.$nombreArchivo);

        return response()->download($rutaArchivo);
    }


    public function edit($id)
    {
        $recurso = Recursos::findOrFail($id);

        return view('Docente.EditarRecursos')->with('recurso', $recurso);

    }

    public function update(Request $request)
    {

        $messages = [
            'tituloRecurso.required' => 'El campo título del recurso es obligatorio.',
            'descripcionRecurso.required' => 'El campo descripción del recurso es obligatorio.',
        ];

        $request->validate([
            'tituloRecurso' => 'required',
            'descripcionRecurso' => 'required',
        ], $messages);



        $recurso = Recursos::findOrFail($request->idRecurso);

        $recurso->nombreRecurso = $request->tituloRecurso;
        $recurso->cursos_id = $request->cursos_id;

        $recurso->descripcionRecursos = $request->descripcionRecurso;
        $recurso->tipoRecurso = $request->tipoRecurso;

        if ($request->hasFile('archivo')) {
            $recursosPath = $request->file('archivo')->store('archivo', 'public');
            $recurso->archivoRecurso = $recursosPath;
        }

        $recurso->save();


        return redirect(route('Curso', $request->cursos_id))->with('success', 'Editado con éxito');



    }

    public function delete($id)
    {
        $recurso = Recursos::findOrFail($id);
        $recurso->delete();

        return back()->with('success', 'Eliminado con éxito');
    }

    public function indexE($id)
    {

        $cursos = Cursos::findOrFail($id);

        $recursos = Recursos::withTrashed()
        ->where('cursos_id', $id)
        ->onlyTrashed()
        ->get();


        return view('Docente.ListaRecursosEliminados')->with('recursos', $recursos)->with('cursos', $cursos);
    }




    public function restore($id)
    {
        $recurso = Recursos::onlyTrashed()->find($id);
        $recurso->restore();

        return back()->with('success', 'Restaurado con éxito');
    }




}
