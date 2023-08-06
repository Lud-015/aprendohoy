<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Horario::create([
            'dias' => 'Lunes, Martes, Miercoles',
            'hora_ini' => '12:00 PM',
            'hora_fin' => '15:00 PM',
        ]);
    }
}
