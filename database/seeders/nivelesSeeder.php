<?php

Namespace Database\Seeders;

use App\Models\Nivel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class nivelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nivel::create(['nombre' => 'PRINCIPIANTE']);
        Nivel::create(['nombre' => 'BASICO 1']);
        Nivel::create(['nombre' => 'BASICO 2']);
        Nivel::create(['nombre' => 'BASICO 3']);
        Nivel::create(['nombre' => 'BASICO 4']);
        Nivel::create(['nombre' => 'PRE-INTERMEDIO']);
        Nivel::create(['nombre' => 'INTERMEDIO 1']);
        Nivel::create(['nombre' => 'INTERMEDIO 2']);
        Nivel::create(['nombre' => 'INTERMEDIO 3']);
        Nivel::create(['nombre' => 'INTERMEDIO 4']);
        Nivel::create(['nombre' => 'AVANZADO 1']);
        Nivel::create(['nombre' => 'AVANZADO 2']);
        Nivel::create(['nombre' => 'AVANZADO 3']);
        Nivel::create(['nombre' => 'AVANZADO 4']);
        Nivel::create(['nombre' => 'AVANZADO 5']);
        Nivel::create(['nombre' => 'AVANZADO 6']);
        Nivel::create(['nombre' => 'AVANZADO 7']);
    }
}
