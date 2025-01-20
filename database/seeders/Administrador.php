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


        $user2 = User::create([

            'name' => 'Juan',
            'lastname1' => 'Perez',
            'lastname2' => 'Perez',
            'CI' => '12345678',
            'Celular' => '1',
            'fechadenac' => now(),
            'PaisReside' => 'Bolivia',
            'CiudadReside' => 'Cochabamba',
            'email' => 'juanperez@gmail.com',
            'password' => bcrypt('JPP12345678'),

        ]);
        $atributosDocentes2 = new atributosDocente();

        $atributosDocentes2->formacion = "";
        $atributosDocentes2->Especializacion = "";
        $atributosDocentes2->ExperienciaL = "";
        $atributosDocentes2->docente_id = User::latest('id')->first()->id;
        $atributosDocentes2->save();


        $user2-> assignRole('Docente');




        $user3 = User::create([

            'name' => 'Lud',
            'lastname1' => 'Machicado',
            'lastname2' => 'Mullisaca',
            'CI' => '12926606',
            'Celular' => '69997562',
            'fechadenac' => now(),
            'PaisReside' => 'Bolivia',
            'CiudadReside' => 'Cochabamba',
            'email' => 'ludtp350@gmail.com',
            'password' => bcrypt('LMM12926606'),

        ]);
        $user3-> assignRole('Estudiante');
    }
}
