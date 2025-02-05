<?php

namespace App\Http\Controllers;

use App\Models\Cuestionario;
use App\Models\Inscritos;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuestionarioController extends Controller
{
    public function index($id)
    {
        $cuestionario = Cuestionario::with(['preguntas' => function ($query) {
            $query->withTrashed()->with(['opciones' => function ($query) {
                $query->withTrashed(); // Incluye las opciones eliminadas lógicamente
            }]);
        }])->findOrFail($id);


        return view('Docente.respuestas')->with('cuestionario', $cuestionario);
    }

    public function mostrarCuestionario($id)
    {
        $cuestionario = Cuestionario::with(['preguntas.opciones'])->findOrFail($id);

        if ($cuestionario->preguntas->isEmpty()) {
            return redirect()->route('Curso', $cuestionario->subtema->tema->curso->id)
                ->with('error', 'Este cuestionario no tiene preguntas disponibles.');
        }

        $inscripcion = Inscritos::where('estudiante_id', Auth::id())
            ->where('cursos_id', $cuestionario->subtema->tema->curso->id)
            ->firstOrFail();

        // Obtener el número de intentos realizados
        $intentosRealizados = Resultados::where('cuestionario_id', $id)
            ->where('estudiante_id', $inscripcion->id)
            ->count();

        // Obtener la mejor nota del estudiante
        $mejorNota = Resultados::where('cuestionario_id', $id)
            ->where('estudiante_id', $inscripcion->id)
            ->max('puntaje_obtenido');

        return response()
            ->view('Estudiante.cuestionario_resolve', compact('cuestionario', 'inscripcion', 'intentosRealizados', 'mejorNota'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    public function procesarRespuestas(Request $request, $id)
    {
        $inscritoId = $request->input('inscrito_id');
        $respuestas = $request->input('respuestas', []);

        // Obtener todas las preguntas del cuestionario
        $cuestionario = Cuestionario::with('preguntas')->findOrFail($id);
        $preguntasIds = $cuestionario->preguntas->pluck('id')->toArray();

        // Verificar si hay preguntas sin responder
        $preguntasSinResponder = array_diff($preguntasIds, array_keys($respuestas ?? []));

        if (!empty($preguntasSinResponder)) {
            return back()
                ->withInput()
                ->with('error', 'Debes responder todas las preguntas antes de enviar el cuestionario.');
        }

        // Validar que cada respuesta tenga un valor válido
        foreach ($respuestas as $preguntaId => $respuesta) {
            if (empty($respuesta) && $respuesta !== '0') {
                return back()
                    ->withInput()
                    ->with('error', 'Todas las preguntas deben tener una respuesta seleccionada.');
            }
        }

        // Obtener el número del siguiente intento
        $numeroIntento = Resultados::where('cuestionario_id', $id)
            ->where('estudiante_id', $inscritoId)
            ->count() + 1;

        // Variables para el puntaje
        $puntajeObtenido = 0;
        $puntajeTotal = 0;

        // Procesar respuestas
        foreach ($respuestas as $preguntaId => $respuesta) {
            $pregunta = Pregunta::find($preguntaId);
            $puntajeTotal += $pregunta->puntos;

            // Verificar si la respuesta es correcta
            if ($pregunta->tipo === 'multiple' || $pregunta->tipo === 'verdadero_falso') {
                $opcionCorrecta = $pregunta->opciones()->where('es_correcta', true)->first();
                if ($opcionCorrecta && $opcionCorrecta->id == $respuesta) {
                    $puntajeObtenido += $pregunta->puntos;
                }
            }

            // Guardar respuesta
            Respuesta::create([
                'pregunta_id' => $preguntaId,
                'estudiante_id' => $inscritoId,
                'respuesta' => is_array($respuesta) ? json_encode($respuesta) : $respuesta,
                'opcion_id' => is_numeric($respuesta) ? $respuesta : null,
                'intento' => $numeroIntento,
            ]);
        }

        // Guardar resultado
        Resultados::create([
            'cuestionario_id' => $id,
            'estudiante_id' => $inscritoId,
            'intento' => $numeroIntento,
            'puntaje_obtenido' => $puntajeObtenido,
            'puntaje_total' => $puntajeTotal,
        ]);

        // Obtener la mejor nota
        $mejorNota = Resultados::where('cuestionario_id', $id)
            ->where('estudiante_id', $inscritoId)
            ->max('puntaje_obtenido');

        return redirect()->route('cuestionario.responder', $id)
            ->with('success', "Intento #{$numeroIntento} completado. Puntaje obtenido: {$puntajeObtenido}/{$puntajeTotal}. Mejor puntaje hasta ahora: {$mejorNota}/{$puntajeTotal}");
    }


    public function store(Request $request, $id)
    {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_habilitacion' => 'required|date',
            'fecha_vencimiento' => 'required|date|after:fecha_habilitacion',
            'puntos' => 'required|numeric|min:0',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'fecha_habilitacion.required' => 'La fecha de habilitación es obligatoria.',
            'fecha_habilitacion.date' => 'La fecha de habilitación debe ser una fecha válida.',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de habilitación.',
            'puntos.required' => 'Los puntos son obligatorios.',
            'puntos.numeric' => 'Los puntos deben ser un número.',
            'puntos.min' => 'Los puntos no pueden ser negativos.',
        ]);

        Cuestionario::create([
            'titulo_cuestionario' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_habilitacion' => $request->fecha_habilitacion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'puntos' => $request->puntos, // Corregí esto, ya que antes estaba asignando 'fecha_vencimiento' a 'puntos'
            'subtema_id' => $id,
        ]);

        return back()->with('success', 'Tema creado correctamente.');
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_habilitacion' => 'required|date',
            'fecha_vencimiento' => 'required|date|after:fecha_habilitacion',
            'puntos' => 'required|numeric|min:0',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'fecha_habilitacion.required' => 'La fecha de habilitación es obligatoria.',
            'fecha_habilitacion.date' => 'La fecha de habilitación debe ser una fecha válida.',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de habilitación.',
            'puntos.required' => 'Los puntos son obligatorios.',
            'puntos.numeric' => 'Los puntos deben ser un número.',
            'puntos.min' => 'Los puntos no pueden ser negativos.',
        ]);

        $cuestionario = Cuestionario::findOrFail($id);

        $cuestionario->update([
            'titulo_cuestionario' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_habilitacion' => $request->fecha_habilitacion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'puntos' => $request->puntos, // Corregí esto, ya que antes estaba asignando 'fecha_vencimiento' a 'puntos'
            'subtema_id' => $id,
        ]);

        return back()->with('success', 'Cuestionario editado correctamente.');
    }




    public function delete($id){
        Cuestionario::find($id)->delete();
        return back()->with('success','Cuestionario Eliminado Correctamente');
    }

    public function restore($id){
        Cuestionario::find($id)->restore();
        return back()->with('success','Cuestionario Restablecido Correctamente');
    }
}
