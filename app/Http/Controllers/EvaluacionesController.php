<?php

namespace App\Http\Controllers;

use App\Events\EvaluacionEvent;
use App\Helpers\TextHelper;
use App\Models\Cursos;
use App\Models\EvaluacionEntrega;
use App\Models\Evaluaciones;
use App\Models\Inscritos;
use App\Models\NotaEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluacionesController extends Controller
{
    public function index($id)
    {
        $cursos = Cursos::findOrFail($id);

        return view('Docente.CrearEvaluacion')->with('cursos', $cursos);

    }

    public function store(Request $request)
    {
        $messages = [
            'tituloEvaluacion.required' => 'El campo título de la evaluación es obligatorio.',
            'evaluacionDescripcion.required' => 'El campo descripción de la evaluación es obligatorio.',
            'fechaHabilitacion.required' => 'El campo fecha de habilitación es obligatorio.',
            'fechaVencimiento.required' => 'El campo fecha de vencimiento es obligatorio.',
            'puntos.required' => 'El campo puntos es obligatorio.',
        ];

        $request->validate([
            'tituloEvaluacion' => 'required',
            'tema_id' => 'required',
            'evaluacionDescripcion' => 'required',
            'fechaHabilitacion' => 'required',
            'fechaVencimiento' => 'required',
            'puntos' => 'required',
        ], $messages);

        $evaluaciones = new Evaluaciones();
        $evaluaciones->titulo_evaluacion =  $request->tituloEvaluacion;
        $evaluaciones->temas_id =  $request->tema_id;
        $evaluaciones->descripcionEvaluacion =  $request->evaluacionDescripcion;
        $evaluaciones->fecha_habilitacion =  date("Y-m-d", strtotime($request->fechaHabilitacion));
        $evaluaciones->fecha_vencimiento =  date("Y-m-d", strtotime($request->fechaVencimiento));
        $evaluaciones->cursos_id = $request->cursos_id;
        $evaluaciones->puntos = floatval($request->puntos);

        if ($request->hasFile('evaluacionArchivo')) {
            $evaluacionArchivo = $request->file('evaluacionArchivo')->store('evaluacionArchivo', 'public');
            $evaluaciones->archivoEvaluacion = $evaluacionArchivo;
        }else {
            // Establecer un valor predeterminado o null en caso de archivo vacío
            $evaluaciones->archivoEvaluacion = ''; // o $tareas->archivoTarea = null;
        }

        event(new EvaluacionEvent($evaluaciones, 'crear'));
        $evaluaciones->save();

        return redirect(route('Curso', $request->cursos_id))->with('success', 'Evaluacion creada exitosamente.');;





    }

    public function show($id)
    {
        $evaluaciones = Evaluaciones::findOrFail($id);

        $entregasEvaluaciones = EvaluacionEntrega::where('evaluacion_id', $id)->get();
        $evaluaciones->descripcionEvaluacionSL = $evaluaciones->descripcionTarea;

        $evaluaciones->descripcionEvaluacion = TextHelper::createClickableLinksAndPreviews($evaluaciones->descripcionEvaluacion);

        $notas = NotaEvaluacion::where('evaluaciones_id', $id)->get();


        return view('Estudiante.evaluaciones')->with('notas', $notas)->with('entregasEvaluaciones', $entregasEvaluaciones)->with('evaluaciones', $evaluaciones);
    }


    public function listadeEntregas($id){

        $evaluaciones = Evaluaciones::findOrFail($id);
        $entregasEvaluaciones = EvaluacionEntrega::where('evaluacion_id', $id)->get();
        $notaEvaluacion = NotaEvaluacion::where('evaluaciones_id', $id)->get();
        $inscritos = Inscritos::all();

        return view('Docente.ListadeEntregasEvaluacion')->with('inscritos', $inscritos)
        ->with('notaEvaluacion', $notaEvaluacion)->with('entregasEvaluaciones', $entregasEvaluaciones)
        ->with('evaluaciones' , $evaluaciones);




    }



    public function edit($id)
    {

        $evaluacion = Evaluaciones::findOrFail($id);

        return view('Docente.EditarEvaluacion')->with('evaluacion', $evaluacion);

    }


    public function listadeEntregasCalificarE(Request $request)
    {

        $calificaciones = $request->input('entregas');

        foreach ($calificaciones as $calificacion) {
            if (isset($calificacion['id']) && $calificacion['id'] !== 'null') {
                // Actualizar la nota existente
                $nota = NotaEvaluacion::findOrFail($calificacion['id']);
                $nota->nota = $calificacion['notaEvaluacion'];
                $nota->retroalimentacion =  $calificacion['retroalimentacion'] ?? '';
                $nota->save();
            } else {
                // Crear una nueva nota
                $notaTarea = $calificacion['notaEvaluacion'];
                $inscripcionId = $calificacion['id_inscripcion'];
                $tareaId = $calificacion['id_evaluacion'];
                $retroalimentacion =  $calificacion['retroalimentacion'] ?? '';

                DB::table('nota_evaluaciones')->insert([
                    'nota' => $notaTarea,
                    'retroalimentacion' => $retroalimentacion,
                    'evaluaciones_id' => $tareaId,
                    'inscripcion_id' => $inscripcionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


    return back()->with('success', 'Notas generadas correctamente');



    }



    public function update(Request $request)
    {

        $messages = [
            'tituloEvaluacion.required' => 'El campo título de la evaluación es obligatorio.',
            'evaluacionDescripcion.required' => 'El campo descripción de la evaluación es obligatorio.',
            'fechaHabilitacion.required' => 'El campo fecha de habilitación es obligatorio.',
            'fechaVencimiento.required' => 'El campo fecha de vencimiento es obligatorio.',
            'puntos.required' => 'El campo puntos es obligatorio.',
        ];

        $request->validate([
            'tituloEvaluacion' => 'required',
            'evaluacionDescripcion' => 'required',
            'fechaHabilitacion' => 'required',
            'fechaVencimiento' => 'required',
            'puntos' => 'required',
        ], $messages);

        $evaluaciones = Evaluaciones::findOrFail($request->idEvaluacion);


        $evaluaciones->titulo_evaluacion =  $request->tituloEvaluacion;
        $evaluaciones->descripcionEvaluacion =  $request->evaluacionDescripcion;
        $evaluaciones->fecha_habilitacion =  date("Y-m-d", strtotime($request->fechaHabilitacion));
        $evaluaciones->fecha_vencimiento =  date("Y-m-d", strtotime($request->fechaVencimiento));
        $evaluaciones->cursos_id = $request->cursos_id;
        $evaluaciones->puntos = floatval($request->puntos);

        if ($request->hasFile('evaluacionArchivo')) {
            $evaluacionArchivo = $request->file('evaluacionArchivo')->store('evaluacionArchivo', 'public');
            $evaluaciones->archivoEvaluacion = $evaluacionArchivo;
        }else {
            // Establecer un valor predeterminado o null en caso de archivo vacío
            $evaluaciones->archivoEvaluacion = ''; // o $tareas->archivoTarea = null;
        }

        $evaluaciones->save();

        return redirect(route('Curso', $request->cursos_id))->with('success', 'Curso editado correctamente.');

    }






    public function delete($id)
    {
        $Evaluaciones = Evaluaciones::findOrFail($id);
        $Evaluaciones->delete();

        return back()->with('success', 'Evaluacion eliminada exitosamente.');
    }


    public function indexEE($id){

        $evaluaciones = Evaluaciones::withTrashed()
        ->where('cursos_id', $id)
        ->onlyTrashed()
        ->get();

        return view('Docente.ListaEvaluacionesEliminadas')->with('evaluaciones',$evaluaciones);

    }


    public function restaurarEvaluacion($id)
    {
        $evaluaciones = Evaluaciones::withTrashed()->findOrFail($id);

        if ($evaluaciones->trashed()) {
            $evaluaciones->restore();
            return back()->with('success', 'Evaluacion restaurada exitosamente.');
        } else {
            return back()->with('error', 'La Evaluacion no está en la papelera.');
        }
    }






}
