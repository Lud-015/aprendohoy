<?php

namespace Database\Seeders;

use App\Models\atributosDocente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Administrador extends Seeder
{
    /**
     * Run the database seeds.  
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([

            'name' => 'Roxana',
            'lastname1' => 'Romay',
            'lastname2' => 'Araujo',
            'CI' => '00',
            'Celular' => '71234567',
            'fechadenac' => now(),
            'PaisReside' => 'Bolivia',
            'CiudadReside' => 'Cochabamba',
            'email' => 'educarparalavida.fund@gmail.com',
            'password' => bcrypt('admin123'),

        ]);
        $atributosDocentes = new atributosDocente();

        $atributosDocentes->formacion = ""; 
        $atributosDocentes->Especializacion = ""; 
        $atributosDocentes->ExperienciaL = ""; 
        $atributosDocentes->docente_id = User::latest('id')->first()->id;
        $atributosDocentes->save();
        

        $user-> assignRole('Administrador');
    }
}
