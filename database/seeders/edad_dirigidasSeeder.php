<?php

namespace Database\Seeders;

use App\Models\EdadDirigida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class edad_dirigidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EdadDirigida::create([
            'nombre' => 'TODAS LAS EDADES',
            'edad1' => 12,
            'edad2' => 90,
        ]);
        EdadDirigida::create([
            'nombre' => 'NIÑOS DE PREESCOLAR',
            'edad1' => 3,
            'edad2' => 5,
        ]);
        EdadDirigida::create([
            'nombre' => 'NIÑOS',
            'edad1' => 7,
            'edad2' => 12,
        ]);
        EdadDirigida::create([
            'nombre' => 'ADOLECENTES',
            'edad1' => 12,
            'edad2' => 18,
        ]);
        EdadDirigida::create([
            'nombre' => 'JOVENES',
            'edad1' => 15,
            'edad2' => 30,
        ]);
        EdadDirigida::create([
            'nombre' => 'ADULTOS',
            'edad1' => 30,
            'edad2' => 60,
        ]);
        EdadDirigida::create([
            'nombre' => 'ADULTOS MAYORES',
            'edad1' => 60,
            'edad2' => 90,
        ]);
        
    }
}
