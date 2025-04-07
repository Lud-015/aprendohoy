<?php

namespace App\Http\Controllers;

use App\Events\EstudianteEvent;
use App\Models\Aportes;
use App\Models\Cursos;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aportes = Aportes::all();
        return view('FundacionPlantillaUsu.aportes')->with('aportes', $aportes);
    }

    public function indexAdmin()
    {
        $estudiantes = User::role('Estudiante')->get();

        $cursos = Cursos::whereDate('fecha_fin', '>=', Carbon::today())->get();


        return view('registraraporte')
        ->with('estudiantes', $estudiantes)
        ->with('cursos', $cursos);

    }


    public function registrarpagoPost(Request $request)
{
    $estudiante_id = $request->input('estudiante_id');
    $estudiante = User::find($estudiante_id);

    // Luego puedes acceder a los detalles del estudiante, por ejemplo:
    return view('registraraporte')->with('estudiante', $estudiante);
}

public function factura($id)
{

    $aportes = Aportes::find($id);


    // Luego puedes acceder a los detalles del estudiante, por ejemplo:
    return view('Aportes.factura')->with('aportes', $aportes);
}



    public function indexStore()
    {

        $cursos = Cursos::all();
        $estudiantes = User::role('Estudiante')->get();


        return view('registraraporte')
        ->with('cursos', $cursos)
        ->with('estudiantes', $estudiantes );

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
        $request->validate([

            'nombre' => 'required',
            'monto' => 'required',
            'descripcion' => 'required',
            'archivo' => 'required',

        ]);

        $aportes = new Aportes();

        $aportes->datosEstudiante = $request->nombre;
        $aportes->DescripcionDelPago = $request->descripcion;

        $aportes->monto = $request->monto;

        $aportes->estudiante_id = $request->estudiante_id;

        if ($request->hasFile('archivo')) {
            $aportesPath = $request->file('archivo')->store('aportes', 'public');
            $aportes->comprobante = $aportesPath;
        }

        $aportes->save();



        return redirect(route('Inicio'))->with('success', 'Pago registrado exitosamente!');
    }


    public function storeadmin(Request $request)
    {
        $request->validate([
            'pagante' => 'required',
            'paganteci' => 'required',
            'montopagar' => 'required|numeric|min:0', // Validar que el monto a pagar sea un número no negativo
            'montocancelado' => 'required|numeric|min:0', // Validar que el monto cancelado sea un número no negativo
            'descripcion' => 'required',
        ], [
            'pagante.required' => 'El nombre del pagante es obligatorio.',
            'paganteci.required' => 'La cédula del pagante es obligatoria.',
            'montopagar.required' => 'El monto a pagar es obligatorio.',
            'montopagar.numeric' => 'El monto a pagar debe ser un número.',
            'montopagar.min' => 'El monto a pagar no puede ser negativo.',
            'montocancelado.required' => 'El monto cancelado es obligatorio.',
            'montocancelado.numeric' => 'El monto cancelado debe ser un número.',
            'montocancelado.min' => 'El monto cancelado no puede ser negativo.',
            'descripcion.required' => 'La descripción del pago es obligatoria.',
        ]);

        $aportes = new Aportes();
        $aportes->codigopago = uniqid();

        $aportes->pagante = $request->pagante;
        $aportes->paganteci = $request->paganteci;


        $estudiante_id = $request->input('estudiante_id');
        $estudiante = User::find($estudiante_id);

        $aportes->datosEstudiante = $estudiante->name .' '. $estudiante->lastname1 . ' ' . $estudiante->lastname2 . ' // ' . $estudiante->CI;
        $aportes->DescripcionDelPago = $request->descripcion;

        $aportes->monto_pagado = $request->montocancelado;
        $aportes->monto_a_pagar = $request->montopagar;


        // Calcular el restante a pagar utilizando el método max para evitar números negativos
        $aportes->restante_a_pagar = max(0, $request->montopagar - $request->montocancelado);

        // Calcular el cambio (si tiene sentido en tu lógica de negocio)
        $aportes->saldo = max(0, $request->montocancelado - $request->montopagar);

        $aportes->estudiante_id = $estudiante_id;

        $aportes->comprobante = '';

        $aportes->save();



        return redirect(route('Inicio'))->with('success', 'Pago registrado exitosamente!');
    }


    public function comprarCurso(Request $request)
    {
        $request->validate([
            'comprobante' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'montopagar' => 'required|numeric|min:0',
            'descripcion' => 'required',
            'curso_id' => 'required|exists:cursos,id' // Ensure curso_id exists
        ]);

        $aportes = new Aportes();
        $aportes->codigopago = uniqid();

        // User information
        $user = auth()->user();
        $aportes->pagante = $user->name.' '.$user->lastname1.' '.$user->lastname2;
        $aportes->paganteci = $user->CI;
        $aportes->estudiante_id = $user->id;

        // Student data
        $aportes->datosEstudiante = $user->name.' '.$user->lastname1.' '.$user->lastname2.' '.$user->CI;

        // Payment information
        $aportes->DescripcionDelPago = $request->input('descripcion');
        $aportes->monto_pagado = 0;
        $aportes->monto_a_pagar = $request->montopagar;
        $aportes->restante_a_pagar = $request->montopagar; // Since monto_pagado is 0
        $aportes->cursos_id = $request->curso_id;
        $aportes->tipopago = 'Comprobante';
        $aportes->saldo = 0;

        // Handle file upload
        if ($request->hasFile('comprobante')) {
            $rutaArchivo = $request->file('comprobante')->store('comprobantes', 'public');
            $aportes->comprobante = $rutaArchivo; // Store the path, not the file object
        }

        $aportes->save();

        return redirect(route('Inicio'))->with('success', 'Tu pago será validado, por favor espere!');
    }


    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aportes  $aportes
     * @return \Illuminate\Http\Response
     */
    public function show(Aportes $aportes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aportes  $aportes
     * @return \Illuminate\Http\Response
     */
    public function edit(Aportes $aportes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aportes  $aportes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aportes $aportes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aportes  $aportes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aportes $aportes)
    {
        //
    }
}
