<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EdadDirigida;
use App\Models\Horario;
use App\Models\Nivel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Roles::class);
        $this->call(Administrador::class);
        $this->call(nivelesSeeder::class);
        $this->call(edad_dirigidasSeeder::class);
        $this->call(HorariosSeeder::class);
    }
}
