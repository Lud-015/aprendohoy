<?php

namespace App\Http\Controllers;

use App\Events\TareaEvent;
use App\Helpers\TextHelper;
use App\Models\Cursos;
use App\Models\Inscritos;
use App\Models\NotaEntrega;
use App\Models\Tareas;
use App\Models\TareasEntrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $cursos = Cursos::findOrFail($id);

        return view('Docente.CrearTarea')->with('cursos', $cursos);

    }

    public function store(Request $request, $id)
    {
        $messages = [
            'tituloTarea.required' => 'El campo título de la tarea es obligatorio.',
            'tareaDescripcion.required' => 'El campo descripción de la tarea es obligatorio.',
            'fechaHabilitacion.required' => 'El campo fecha de habilitación es obligatorio.',
            'fechaVencimiento.required' => 'El campo fecha de vencimiento es obligatorio.',
            'puntos.required' => 'El campo puntos es obligatorio.',
        ];

        $request->validate([
            'tituloTarea' => 'required',
            'tareaDescripcion' => 'required',
            'fechaHabilitacion' => 'required',
            'fechaVencimiento' => 'required',
            'puntos' => 'required',
        ], $messages);


        $tareas = new Tareas();
        $tareas->titulo_tarea =  $request->tituloTarea;
        $tareas->descripcion_tarea =  $request->tareaDescripcion;
        $tareas->fecha_habilitacion =  date("Y-m-d", strtotime($request->fechaHabilitacion));
        $tareas->fecha_vencimiento =  date("Y-m-d", strtotime($request->fechaVencimiento));
        $tareas->subtema_id = $id;
        $tareas->puntos = doubleval($request->puntos);

        if ($request->hasFile('tareaArchivo')) {
            $tareaArchivo = $request->file('tareaArchivo')->store('tareaArchivo', 'public');
            $tareas->archivoTarea = $tareaArchivo;
        }else {
            // Establecer un valor predeterminado o null en caso de archivo vacío
            $tareas->archivo_requerido = ''; // o $tareas->archivoTarea = null;
        }

        // event(new TareaEvent($tareas, 'crear'));
        $tareas->save();

        return redirect()->back()->with('success', 'Tarea creada con éxito');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tareas  $tareas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tareas = Tareas::findOrFail($id);
        $tareas->descripcionTareaSL = $tareas->descripcionTarea;

        $tareas->descripcionTarea = TextHelper::createClickableLinksAndPreviews($tareas->descripcionTarea);

        $entregas = TareasEntrega::where('tarea_id', $id)->get();

        $notas = NotaEntrega::where('tarea_id', $id)->get();



        return view('Estudiante.tarea')->with('notas', $notas)->with('entregas', $entregas)->with('tareas', $tareas);
    }



    public function listadeEntregas($id){

        $tareas = Tareas::findOrFail($id);
        $entregasTareas = TareasEntrega::where('tarea_id', $id)->get();
        $inscritos = Inscritos::all();
        $notaTarea = NotaEntrega::where('tarea_id', $id)->get();


        return view('Docente.ListadeEntregas')->with('inscritos', $inscritos)->with('notaTarea', $notaTarea)->with('tareas' , $tareas)->with('entregasTareas', $entregasTareas);




    }

    public function listadeEntregasCalificar(Request $request, $id = null)
    {

        $calificar = $request->input('entregas');


        foreach ($calificar as $calificarItem) {
            // Verificar si la clave 'id' está definida en el arreglo actual
            if (isset($calificarItem['id'])) {
                $notaid = $calificarItem['id'];
                $nota = NotaEntrega::findOrFail($notaid);

                $nota->nota = $calificarItem['notaTarea'];
                $nota->retroalimentacion = $calificarItem['retroalimentacion'];
                $nota->save();
            } elseif($calificarItem['id'] = 'null') {
                $notaTarea = $calificarItem['notaTarea'];
                $inscritos_id = $calificarItem['id_inscripcion'];
                $tareaid = $calificarItem['id_tarea'];
                $retroalimentacion = $calificarItem['retroalimentacion'];

                DB::table('nota_entregas')->insert([
                    'nota' => $notaTarea,
                    'retroalimentacion' => $retroalimentacion,
                    'tarea_id' => $tareaid,
                    'inscripcion_id' => $inscritos_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


        return back()->with('success', 'Tareas calificadas correctamente');


    }

    public function edit($id)
    {

        $tarea = Tareas::findOrFail($id);

        return view('Docente.EditarTarea')->with('tarea', $tarea);

    }



    public function update(Request $request)
    {

        $messages = [
            'tituloTarea.required' => 'El campo título de la tarea es obligatorio.',
            'tareaDescripcion.required' => 'El campo descripción de la tarea es obligatorio.',
            'fechaHabilitacion.required' => 'El campo fecha de habilitación es obligatorio.',
            'fechaVencimiento.required' => 'El campo fecha de vencimiento es obligatorio.',
            'puntos.required' => 'El campo puntos es obligatorio.',
        ];

        $request->validate([
            'tituloTarea' => 'required',
            'tareaDescripcion' => 'required',
            'fechaHabilitacion' => 'required',
            'fechaVencimiento' => 'required',
            'puntos' => 'required',
        ], $messages);


        $tareas = Tareas::findOrFail($request->idTarea);


        $tareas->titulo_tarea =  $request->tituloTarea;
        $tareas->descripcionTarea =  $request->tareaDescripcion;
        $tareas->fecha_habilitacion =  date("Y-m-d", strtotime($request->fechaHabilitacion));
        $tareas->fecha_vencimiento =  date("Y-m-d", strtotime($request->fechaVencimiento));
        $tareas->cursos_id = $request->cursos_id;
        $tareas->puntos = floatval($request->puntos);

        if ($request->hasFile('tareaArchivo')) {
            $tareaArchivo = $request->file('tareaArchivo')->store('tareaArchivo', 'public');
            $tareas->archivoTarea = $tareaArchivo;
        }else {
            // Establecer un valor predeterminado o null en caso de archivo vacío
            $tareas->archivoTarea = ''; // o $tareas->archivoTarea = null;
        }

        $tareas->save();

        return redirect(route('Curso', $request->cursos_id))->with('success', 'Tarea Editada Correctamente!');

    }

    public function delete($id)
    {
        $tarea = Tareas::findOrFail($id);
        $tarea->delete();

        return back()->with('success','Tarea eliminada con éxito');
    }


    public function indexTE($id){

        $tareas = Tareas::withTrashed()
        ->where('cursos_id', $id)
        ->onlyTrashed()
        ->get();

        return view('Docente.ListaTareasEliminadas')->with('tareas',$tareas);

    }


    public function restaurarTarea($id)
    {
        $tarea = Tareas::withTrashed()->findOrFail($id);

        if ($tarea->trashed()) {
            $tarea->restore();
            return back()->with('success', 'Tarea restaurada exitosamente.');
        } else {
            return back()->with('error', 'La tarea no está en la papelera.');
        }
    }
}
