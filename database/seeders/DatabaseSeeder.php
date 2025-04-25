<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EdadDirigida;
use App\Models\Horario;
use App\Models\Nivel;
use Carbon\Carbon;
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
        $this->call(Roles::class);
        $this->call(Administrador::class);
        DB::table('cursos')->insert([
            [
                'nombreCurso' => 'Curso de Programación',
                'codigoCurso' => 'CP001',
                'descripcionC' => 'Un curso intensivo de programación.',
                'fecha_ini' => '2025-02-01',
                'fecha_fin' => '2025-06-01',
                'archivoContenidodelCurso' => null,
                'notaAprobacion' => 75,
                'formato' => 'Online',
                'estado' => 'Activo',
                'tipo' => 'curso',
                'duracion' => 0,
                'cupos' => 0,
                'docente_id' => 1,
                'edad_dirigida' => 'Adultos',
                'nivel' => 'Intermedio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombreCurso' => 'Congreso de Ciencias',
                'codigoCurso' => 'CC001',
                'descripcionC' => 'Congreso sobre los últimos avances en ciencias.',
                'fecha_ini' => '2025-03-01',
                'fecha_fin' => '2025-03-05',
                'archivoContenidodelCurso' => null,
                'notaAprobacion' => null,
                'formato' => 'Presencial',
                'estado' => 'Activo',
                'tipo' => 'congreso',
                'duracion' => 0,
                'cupos' => 0,
                'docente_id' => 1,
                'edad_dirigida' => 'Adolescentes',
                'nivel' => 'Avanzado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}
