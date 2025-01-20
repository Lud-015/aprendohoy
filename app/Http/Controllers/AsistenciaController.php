<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Cursos;
use App\Models\Inscritos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class AsistenciaController extends Controller
{
    public function index($id){
        $cursos = Cursos::findOrFail($id);

        $inscritos = Inscritos::whereNull('deleted_at')->get();

        return view('Docente.ListaAsistencia')->with('cursos', $cursos)->with('inscritos', $inscritos);
    }

    public function store(Request $request){


        $asistencias = $request->input('asistencia');

        $errors = []; // Initialize an array to store validation errors

foreach ($asistencias as $asistencia) {
    $curso_id = $asistencia['curso_id'];
    $inscritos_id = $asistencia['inscritos_id'];
    $fechaAsistencia = $request->fecha_asistencia;
    $tipoasistencia = $asistencia['tipo_asistencia'];

    // Define validation rules for tipoasistencia
    $tipoasistenciaRules = ['required']; // Customize the allowed types

    // Validate the tipoasistencia field
    $validator = Validator::make(['tipoasistencia' => $tipoasistencia], [
        'tipoasistencia' => $tipoasistenciaRules,
    ]);

    if ($validator->fails()) {
        // Add an error message to the $errors array
        $errors[] = "Validation failed for tipoasistencia: " . implode(', ', $validator->errors()->get('tipoasistencia'));
    }else{
        // Check for an existing record
        $existingRecord = DB::table('asistencia')
            ->where('curso_id', $curso_id)
            ->where('inscripcion_id', $inscritos_id)
            ->where('fechaasistencia', $fechaAsistencia)
            ->first();

        if (!$existingRecord) {
            // Insert the record if no matching combination exists
            DB::table('asistencia')->insert([
                'tipoAsitencia' => $tipoasistencia,
                'fechaasistencia' => $fechaAsistencia,
                'curso_id' =>  $curso_id,
                'inscripcion_id' => $inscritos_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Add an error message to the $errors array
            $errors[] = "Ya realizaste la asistencia de hoy";
        }
    }
}

if (!empty($errors)) {
    return back()->with('error', 'Se produjeron errores de validación. Por favor verifique los datos.');
} else {
    return back()->with('success', 'Asistencia registrada Correctamente.');
}









    }

    public function show($id){

        $cursos = Cursos::findOrFail($id);
        $inscritos = Inscritos::where('cursos_id', $id)->whereNull('deleted_at')->get();
        $asistencias  = Asistencia::where('curso_id', $id)->whereNull('deleted_at')->get();


        return view('Docente.HistorialAsistencia')->with('asistencias', $asistencias)->with('inscritos', $inscritos)->with('cursos', $cursos);



    }

    public function edit(Request $request){

        $asistencias = $request->input('asistencia');

        foreach($asistencias as $asistencias){

            $asistenciaid = $asistencias['id'];
            $asistencia = Asistencia::findOrFail($asistenciaid);

            $asistencia->tipoAsitencia = $asistencias['tipo_asistencia'];
            $asistencia->save();



        }

        return back()->with('success', 'Asistencia editada Correctamente');
    }

    public function index2($id){

        $cursos = Cursos::findOrFail($id);
        $inscritos = Inscritos::where('cursos_id', $id)->get();

        return view('Docente.AsignarAsistencia')->with('cursos', $cursos)->with('inscritos', $inscritos);

    }

    public function store2(Request $request){

        $messages = [
            'estudiante.required' => 'El campo estudiante es obligatorio.',
            'fecha.required' => 'El campo fecha es obligatorio.',
            'curso_id.required' => 'El campo curso_id es obligatorio.',
            'asistencia.required' => 'El campo asistencia es obligatorio.',
        ];

        $request->validate([
            'estudiante' => 'required',
            'fecha' => 'required',
            'curso_id' => 'required',
            'asistencia' => 'required',
        ], $messages);

        $existingRecord = DB::table('asistencia')
            ->where('curso_id', $request->curso_id)
            ->where('inscripcion_id', $request->estudiante)
            ->where('fechaasistencia', $request->fecha)
            ->first();

        if (!$existingRecord) {
            // Insert the record if no matching combination exists
            DB::table('asistencia')->insert([
                'tipoAsitencia' => $request->asistencia,
                'fechaasistencia' => $request->fecha,
                'curso_id' => $request->curso_id,
                'inscripcion_id' => $request->estudiante,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()
                ->with('success', 'Asistencia registrada exitosamente.');
        } else {
            // Use the Laravel validation error bag for consistency
            return back()->withErrors(['error' => 'Ya realizaste la asistencia de ese estudiante']);
        }


    }



}
