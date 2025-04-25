<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AchievementsTableSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'title' => 'Novato',
                'description' => 'Has ganado tus primeros 100 XP',
                'icon' => 'badge_novato.png',
                'xp_reward' => 100,
            ],
            [
                'title' => 'Constante',
                'description' => 'Te conectaste 7 días seguidos',
                'icon' => 'badge_constante.png',
                'xp_reward' => 200,
            ],
            [
                'title' => 'Explorador',
                'description' => 'Completaste 5 actividades diferentes',
                'icon' => 'badge_explorador.png',
                'xp_reward' => 150,
            ],
            [
                'title' => 'Nivelado',
                'description' => 'Alcanzaste el Nivel 5',
                'icon' => 'badge_nivelado.png',
                'xp_reward' => 250,
            ],
            [
                'title' => 'Maestro XP',
                'description' => 'Alcanzaste 1000 puntos de experiencia',
                'icon' => 'badge_maestro_xp.png',
                'xp_reward' => 300,
            ],
            [
                'title' => 'Socializador',
                'description' => 'Completaste 10 interacciones con otros usuarios',
                'icon' => 'badge_socializador.png',
                'xp_reward' => 150,
            ],
            [
                'title' => 'Perfeccionista',
                'description' => 'Completaste una actividad con 100% de precisión',
                'icon' => 'badge_perfeccionista.png',
                'xp_reward' => 175,
            ],
            [
                'title' => 'Rayo Veloz',
                'description' => 'Completaste 3 actividades en menos de 24 horas',
                'icon' => 'badge_rayo_veloz.png',
                'xp_reward' => 200,
            ],
            [
                'title' => 'Coleccionista',
                'description' => 'Desbloqueaste 10 logros diferentes',
                'icon' => 'badge_coleccionista.png',
                'xp_reward' => 300,
            ],
            [
                'title' => 'Mentor',
                'description' => 'Ayudaste a 3 nuevos usuarios',
                'icon' => 'badge_mentor.png',
                'xp_reward' => 250,
            ],
            [
                'title' => 'Sin Descanso',
                'description' => 'Te conectaste 30 días seguidos',
                'icon' => 'badge_sin_descanso.png',
                'xp_reward' => 500,
            ],
            [
                'title' => 'Polímata',
                'description' => 'Completaste actividades en 5 categorías diferentes',
                'icon' => 'badge_polimata.png',
                'xp_reward' => 350,
            ],
            [
                'title' => 'Leyenda',
                'description' => 'Alcanzaste el Nivel 10',
                'icon' => 'badge_leyenda.png',
                'xp_reward' => 1000,
            ],
            [
                'title' => 'Primeros Pasos',
                'description' => 'Completaste tu primera actividad',
                'icon' => 'badge_primeros_pasos.png',
                'xp_reward' => 50,
            ],
            [
                'title' => 'Noctámbulo',
                'description' => 'Completaste una actividad entre las 12am y 5am',
                'icon' => 'badge_noctambulo.png',
                'xp_reward' => 100,
            ],
        ];


        foreach ($achievements as &$achievement) {
            $achievement['slug'] = Str::slug($achievement['title']);
            $achievement['created_at'] = Carbon::now();
            $achievement['updated_at'] = Carbon::now();
        }

        DB::table('achievements')->insert($achievements);
    }
}
