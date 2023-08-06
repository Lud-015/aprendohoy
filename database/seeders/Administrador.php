<?php

namespace Database\Seeders;

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
            'email' => 'educarparalavida.fund@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),

        ]);

        $user-> assignRole('Administrador');
    }
}
