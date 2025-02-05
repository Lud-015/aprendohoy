<?php

namespace App\Http\Controllers;

use App\Models\RecursoSubtema;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecursoSubtemaController extends Controller
{
    public function store(Request $request, $id)
    {



        $messages = [
            'tituloRecurso.required' => 'El título del recurso es obligatorio.',
            'tituloRecurso.max' => 'El título no puede superar los 255 caracteres.',
            'descripcionRecurso.required' => 'La descripción del recurso es obligatoria.',
            'archivo.file' => 'El archivo debe ser un archivo válido.',
            'archivo.mimes' => 'El archivo debe ser de tipo: jpg, jpeg, png, pdf, doc, docx o zip.',
            'archivo.max' => 'El archivo no debe superar los 2MB.',
        ];

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'tituloRecurso' => 'required|string|max:255',
            'descripcionRecurso' => 'required|string',
            'tipoRecurso' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:2048',
        ], $messages);

        // Crear una nueva instancia del modelo Recursos
        $recurso = new RecursoSubtema();
        $recurso->nombreRecurso = $validatedData['tituloRecurso'];
        $recurso->subtema_id = $id;

        // Procesar la descripción para detectar y manejar enlaces de YouTube
        $descripcion = $validatedData['descripcionRecurso'];
        $recurso->descripcionRecursos = $this->procesarDescripcionConIframe($descripcion);

        // Asignar el tipo de recurso si existe
        $recurso->tipoRecurso = $validatedData['tipoRecurso'] ?? null;

        // Procesar archivo adjunto si se incluye
        if ($request->hasFile('archivo')) {
            $recurso->archivoRecurso = $request->file('archivo')->store('archivo', 'public');
        }

        // Guardar el recurso en la base de datos
        $recurso->save();

        // Redirigir con un mensaje de éxito
        return redirect(route('Curso', $id))->with('success', 'Recurso creado con éxito');
    }


    private function procesarDescripcionConIframe(string $descripcion): string
    {
        $iframe = '';

        if (Str::contains($descripcion, ['youtube.com', 'youtu.be'])) {
            $videoId = '';

            if (Str::contains($descripcion, 'youtu.be')) {
                $videoId = Str::after($descripcion, 'youtu.be/');
            } elseif (Str::contains($descripcion, 'youtube.com')) {
                $videoId = Str::between($descripcion, 'v=', '&') ?: Str::after($descripcion, 'v=');
            }

            if ($videoId) {
                $iframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

                // Eliminar el enlace de YouTube del texto para evitar duplicados
                $descripcion = Str::replace([
                    'https://www.youtube.com/watch?v=' . $videoId,
                    'https://youtu.be/' . $videoId
                ], '', $descripcion);
            }
        }

        return $descripcion . ($iframe ? "\n\n" . $iframe : '');
    }


    public function descargar($nombreArchivo)
    {
        $rutaArchivo = storage_path('/app/public/'.$nombreArchivo);

        return response()->download($rutaArchivo);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'tituloRecurso.required' => 'El campo título del recurso es obligatorio.',
            'descripcionRecurso.required' => 'El campo descripción del recurso es obligatorio.',
        ];

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'tituloRecurso' => 'required|string|max:255',
            'descripcionRecurso' => 'required|string',
            'tipoRecurso' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:2048',
        ], $messages);

        // Buscar el recurso a editar
        $recurso = RecursoSubtema::findOrFail($id);

        // Actualizar los campos del recurso
        $recurso->nombreRecurso = $validatedData['tituloRecurso'];

        // Procesar la descripción para detectar y manejar enlaces de YouTube
        $descripcion = $validatedData['descripcionRecurso'];
        $recurso->descripcionRecursos = $this->procesarDescripcionConIframe($descripcion);

        // Actualizar el tipo de recurso si se proporciona
        $recurso->tipoRecurso = $validatedData['tipoRecurso'] ?? $recurso->tipoRecurso;

        // Procesar archivo si se incluye uno nuevo
        if ($request->hasFile('archivo')) {
            // Opcional: eliminar el archivo anterior si aplica
            if ($recurso->archivoRecurso && \Storage::disk('public')->exists($recurso->archivoRecurso)) {
                \Storage::disk('public')->delete($recurso->archivoRecurso);
            }

            // Guardar el nuevo archivo
            $recursosPath = $request->file('archivo')->store('archivo', 'public');
            $recurso->archivoRecurso = $recursosPath;
        }

        // Guardar los cambios en la base de datos
        $recurso->save();

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Recurso editado con éxito');
    }

    public function delete($id)
    {
        $recurso = RecursoSubtema::findOrFail($id);
        $recurso->delete();

        return back()->with('success', 'Eliminado con éxito');
    }


    public function restore($id)
    {
        $recurso = RecursoSubtema::onlyTrashed()->find($id);
        $recurso->restore();

        return back()->with('success', 'Restaurado con éxito');
    }



}
