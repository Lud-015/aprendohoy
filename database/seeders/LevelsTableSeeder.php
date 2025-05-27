<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            [
                'level_number' => 1,
                'required_xp' => 0,
                'title' => 'Principiante',
                'description' => 'Comienza tu viaje de aprendizaje',
                'badge_image' => 'badges/level1.png'
            ],
            [
                'level_number' => 2,
                'required_xp' => 100,
                'title' => 'Aprendiz',
                'description' => 'Estás dando tus primeros pasos',
                'badge_image' => 'badges/level2.png'
            ],
            [
                'level_number' => 3,
                'required_xp' => 250,
                'title' => 'Estudiante',
                'description' => 'Vas por buen camino',
                'badge_image' => 'badges/level3.png'
            ],
            [
                'level_number' => 4,
                'required_xp' => 500,
                'title' => 'Aventurero',
                'description' => 'Exploras nuevos horizontes',
                'badge_image' => 'badges/level4.png'
            ],
            [
                'level_number' => 5,
                'required_xp' => 1000,
                'title' => 'Experto',
                'description' => 'Dominas los conceptos básicos',
                'badge_image' => 'badges/level5.png'
            ],
            [
                'level_number' => 6,
                'required_xp' => 2000,
                'title' => 'Maestro',
                'description' => 'Tu conocimiento es admirable',
                'badge_image' => 'badges/level6.png'
            ],
            [
                'level_number' => 7,
                'required_xp' => 3500,
                'title' => 'Sabio',
                'description' => 'Tu sabiduría inspira a otros',
                'badge_image' => 'badges/level7.png'
            ],
            [
                'level_number' => 8,
                'required_xp' => 5500,
                'title' => 'Erudito',
                'description' => 'Tu conocimiento es excepcional',
                'badge_image' => 'badges/level8.png'
            ],
            [
                'level_number' => 9,
                'required_xp' => 8000,
                'title' => 'Leyenda',
                'description' => 'Tu dedicación es legendaria',
                'badge_image' => 'badges/level9.png'
            ],
            [
                'level_number' => 10,
                'required_xp' => 11000,
                'title' => 'Maestro Supremo',
                'description' => 'Has alcanzado la cima del conocimiento',
                'badge_image' => 'badges/level10.png'
            ],
        ];

        foreach ($levels as $level) {
            Level::updateOrCreate(
                ['level_number' => $level['level_number']],
                $level
            );
        }
    }
} 