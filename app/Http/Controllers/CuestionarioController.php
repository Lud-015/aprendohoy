<?php

namespace App\Http\Controllers;

use App\Models\Evaluaciones;
use App\Models\PreguntaTarea;
use App\Models\RespuestaTareas;
use App\Models\Tareas;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CuestionarioController extends Controller
{
    public function cuestionarioTIndex($id){
        $tarea = Tareas::findOrFail($id);
        $pregunta = PreguntaTarea::where('tarea_id', $id)->get();

        return view('Docente.cuestionario')->with('tarea', $tarea)->with('pregunta', $pregunta);
    }

    public function cuestionarioTSolve($id)
    {
        $tarea = Tareas::findOrFail($id);
        $pregunta = PreguntaTarea::with('respuestas')->where('tarea_id', $id)->get();

        $quizData = $pregunta->map(function($pregunta) {
            return [
                'id' => $pregunta->id,
                'tarea_id' => $pregunta->tarea_id,
                'tipo_preg' => $pregunta->tipo_preg,
                'texto_pregunta' => $pregunta->texto_pregunta,
                'puntos' => $pregunta->puntos,
                'choices' => $pregunta->respuestas->map(function($respuesta) {
                    return [
                        'id' => $respuesta->id,
                        'texto_respuesta' => $respuesta->texto_respuesta,
                        'es_correcta' => $respuesta->es_correcta,
                    ];
                }),
                'pointerEvents' => false,
                'secondsLeft' => 20,
                'AnsweredQue' => ''
            ];
        });

        // Detectar si la solicitud es una petición de API
        if (request()->wantsJson()) {
            return response()->json([
                'quizData' => $quizData,
                'tarea' => $tarea
            ]);
        }

        // Si no es una petición JSON, devolver la vista normal
        return view('Estudiante.quizz', [
            'quizData' => $quizData,
            'tarea' => $tarea,
            'pregunta' => $pregunta
        ]);
    }


    public function cuestionarioTResults($id){
        $evaluacion = Evaluaciones::findOrFail($id);

        return view('Docente.cuestionario')->with('evaluacion', $evaluacion);
    }



    public function cuestionarioEIndex($id){
        $evaluacion = Evaluaciones::findOrFail($id);

        return view('Docente.cuestionario')->with('evaluacion', $evaluacion);
    }

    public function cuestionarioEResults($id){
        $evaluacion = Evaluaciones::findOrFail($id);

        return view('Docente.cuestionario')->with('evaluacion', $evaluacion);
    }


    public function crearPreguntaIndex($id){
        $tarea = Tareas::findOrFail($id);

        return view('Docente.CrearPregunta')->with('tarea', $tarea);
    }


    public function editarPreguntaIndexT($id){
        $pregunta = PreguntaTarea::findOrFail($id);
        return view('Docente.EditarPregunta')->with('pregunta', $pregunta);
    }
    public function editarPreguntaPost(Request $request){
        $pregunta = PreguntaTarea::findOrFail($request->id);


        $pregunta->tipo_preg = $request->tipo;
        $pregunta->texto_pregunta = $request->pregunta;
        $pregunta->puntos = $request->puntos;


        $pregunta->save();




        return redirect(route('cuestionario', $pregunta->tarea_id))->with('success','Pregunta editada correctamente!!');
    }


    public function respuestas($id){
        $pregunta = PreguntaTarea::findOrFail($id);

        $respuesta = RespuestaTareas::where('pregunta_id',$id)->get();
        return view('Docente.respuestas')->with('respuesta', $respuesta)->with('pregunta', $pregunta);
    }

    public function responder(){
        $preguntas = PreguntaTarea::with('respuestas')->get();

        // return view('Estudiante.quizz')->with('preguntas', $preguntas);

        return new BinaryFileResponse(public_path('godot/HTML/cuestionario.html'));

    }


    public function apiTemas(){
        $temas = Tareas::where('tipo_tarea', 'cuestionario')->get();


        return response()->json($temas);
    }


}
