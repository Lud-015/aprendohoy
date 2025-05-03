<?php

namespace App\Http\Controllers;

use App\Events\EvaluacionEvent;
use App\Models\Cursos;
use App\Models\EvaluacionEntrega;
use App\Models\Evaluaciones;
use App\Models\Cuestionario;
use App\Models\Inscritos;
use App\Models\NotaEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvaluacionesController extends Controller
{
    // Mostrar la vista para crear una evaluación
    public function index($id)
    {
        $cursos = Cursos::findOrFail($id);
        $cuestionarios = Cuestionario::all(); // Obtener todos los cuestionarios disponibles
        return view('Docente.CrearEvaluacion', compact('cursos', 'cuestionarios'));
    }

    // Crear una nueva evaluación
    public function store(Request $request)
    {
        $this->validateEvaluacion($request);

        $evaluaciones = new Evaluaciones();
        $this->saveEvaluacionData($evaluaciones, $request);

        event(new EvaluacionEvent($evaluaciones, 'crear'));

        return redirect(route('Curso', $request->cursos_id))->with('success', 'Evaluación creada exitosamente.');
    }

    // Mostrar una evaluación específica
    public function show($id)
    {
        $evaluaciones = Evaluaciones::findOrFail($id);
        $entregasEvaluaciones = EvaluacionEntrega::where('evaluacion_id', $id)->get();
        $notas = NotaEvaluacion::where('evaluaciones_id', $id)->get();

        return view('Estudiante.evaluaciones', compact('evaluaciones', 'entregasEvaluaciones', 'notas'));
    }

    // Mostrar lista de entregas de una evaluación
    public function listadeEntregas($id)
    {
        $evaluaciones = Evaluaciones::findOrFail($id);
        $entregasEvaluaciones = EvaluacionEntrega::where('evaluacion_id', $id)->get();
        $notaEvaluacion = NotaEvaluacion::where('evaluaciones_id', $id)->get();
        $inscritos = Inscritos::all();

        return view('Docente.ListadeEntregasEvaluacion', compact('evaluaciones', 'entregasEvaluaciones', 'notaEvaluacion', 'inscritos'));
    }

    // Editar una evaluación
    public function edit($id)
    {
        $evaluacion = Evaluaciones::findOrFail($id);
        $cuestionarios = Cuestionario::all(); // Obtener todos los cuestionarios disponibles
        return view('Docente.EditarEvaluacion', compact('evaluacion', 'cuestionarios'));
    }

    // Actualizar una evaluación existente
    public function update(Request $request, $id)
    {
        $this->validateEvaluacion($request);

        $evaluaciones = Evaluaciones::findOrFail($id);
        $this->saveEvaluacionData($evaluaciones, $request);

        return redirect(route('Curso', $request->cursos_id))->with('success', 'Evaluación actualizada correctamente.');
    }

    // Eliminar una evaluación
    public function delete($id)
    {
        $evaluaciones = Evaluaciones::findOrFail($id);
        $evaluaciones->delete();

        return back()->with('success', 'Evaluación eliminada exitosamente.');
    }

    // Mostrar evaluaciones eliminadas
    public function indexEE($id)
    {
        $evaluaciones = Evaluaciones::withTrashed()
            ->where('cursos_id', $id)
            ->onlyTrashed()
            ->get();

        return view('Docente.ListaEvaluacionesEliminadas', compact('evaluaciones'));
    }

    // Restaurar una evaluación eliminada
    public function restaurarEvaluacion($id)
    {
        $evaluaciones = Evaluaciones::withTrashed()->findOrFail($id);

        if ($evaluaciones->trashed()) {
            $evaluaciones->restore();
            return back()->with('success', 'Evaluación restaurada exitosamente.');
        }

        return back()->with('error', 'La evaluación no está en la papelera.');
    }

    // Validar los datos de la evaluación
    private function validateEvaluacion(Request $request)
    {
        $messages = [
            'tituloEvaluacion.required' => 'El campo título de la evaluación es obligatorio.',
            'evaluacionDescripcion.required' => 'El campo descripción de la evaluación es obligatorio.',
            'fechaHabilitacion.required' => 'El campo fecha de habilitación es obligatorio.',
            'fechaVencimiento.required' => 'El campo fecha de vencimiento es obligatorio.',
            'puntos.required' => 'El campo puntos es obligatorio.',
        ];

        $request->validate([
            'tituloEvaluacion' => 'required|string|max:255',
            'evaluacionDescripcion' => 'required|string',
            'fechaHabilitacion' => 'required|date',
            'fechaVencimiento' => 'required|date',
            'puntos' => 'required|numeric',
            'esCuestionario' => 'required|boolean',
            'intentosPermitidos' => 'nullable|integer|min:1',
            'cuestionario_id' => 'nullable|exists:cuestionarios,id', // Validar cuestionario asociado
        ], $messages);
    }

    // Guardar o actualizar los datos de la evaluación
    private function saveEvaluacionData(Evaluaciones $evaluaciones, Request $request)
    {
        $evaluaciones->titulo_evaluacion = $request->tituloEvaluacion;
        $evaluaciones->temas_id = $request->tema_id;
        $evaluaciones->descripcionEvaluacion = $request->evaluacionDescripcion;
        $evaluaciones->fecha_habilitacion = date("Y-m-d", strtotime($request->fechaHabilitacion));
        $evaluaciones->fecha_vencimiento = date("Y-m-d", strtotime($request->fechaVencimiento));
        $evaluaciones->cursos_id = $request->cursos_id;
        $evaluaciones->puntos = floatval($request->puntos);
        $evaluaciones->es_cuestionario = $request->esCuestionario;
        $evaluaciones->intentos_permitidos = $request->esCuestionario ? $request->intentosPermitidos : null;
        $evaluaciones->cuestionario_id = $request->cuestionario_id; // Asociar cuestionario

        if ($request->hasFile('evaluacionArchivo')) {
            // Eliminar archivo anterior si existe
            if ($evaluaciones->archivoEvaluacion && Storage::disk('public')->exists($evaluaciones->archivoEvaluacion)) {
                Storage::disk('public')->delete($evaluaciones->archivoEvaluacion);
            }

            // Guardar nuevo archivo
            $evaluaciones->archivoEvaluacion = $request->file('evaluacionArchivo')->store('evaluacionArchivo', 'public');
        }

        $evaluaciones->save();
    }
}
