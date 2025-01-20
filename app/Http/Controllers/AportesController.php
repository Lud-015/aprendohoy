<?php

namespace App\Http\Controllers;

use App\Events\EstudianteEvent;
use App\Models\Aportes;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('registraraporte')->with('estudiantes', $estudiantes);

    }


    public function registrarpagoPost(Request $request)
{
    $estudiante_id = $request->input('estudiante_id');
    $estudiante = User::find($estudiante_id);

    // Luego puedes acceder a los detalles del estudiante, por ejemplo:
    return view('registraraporte')->with('estudiante', $estudiante);
}

public function vistaPrevia($id)
{

    $aportes = Aportes::find($id);


    // Luego puedes acceder a los detalles del estudiante, por ejemplo:
    return view('Aportes.factura')->with('aportes', $aportes);
}



    public function indexStore()
    {

        return view('registraraporte');

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
