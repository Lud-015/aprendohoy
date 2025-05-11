<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EdadDirigida;
use App\Models\Horario;
use App\Models\Nivel;
use Carbon\Carbon;
use CursoSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Roles::class,
            Administrador::class,
            CursoSeeeder::class,
            TipoEvaluacionesSeeder::class,
            TipoActividadesSeeder::class,
            XpEventTypesSeeder::class,
        ]);
    }
}
