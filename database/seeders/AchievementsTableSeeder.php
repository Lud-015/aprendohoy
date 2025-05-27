<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AchievementsTableSeeder extends Seeder
{
    public function run()
    {
        $achievementTypes = [
            'QUIZ_MASTER' => [
                'title' => 'Maestro de Cuestionarios',
                'description' => 'Completa {value} cuestionarios con calificación perfecta',
                'values' => [1, 5, 10, 25, 50],
                'xp_rewards' => [100, 250, 500, 1000, 2000],
                'icons' => ['🎯', '🎯🎯', '🎯🎯🎯', '🎯🎯🎯🎯', '🎯🎯🎯🎯🎯']
            ],
            'FORUM_CONTRIBUTOR' => [
                'title' => 'Contribuidor del Foro',
                'description' => 'Participa en {value} discusiones del foro',
                'values' => [1, 10, 25, 50, 100],
                'xp_rewards' => [50, 150, 300, 600, 1200],
                'icons' => ['💭', '💭💭', '💭💭💭', '💭💭💭💭', '💭💭💭💭💭']
            ],
            'RESOURCE_EXPLORER' => [
                'title' => 'Explorador de Recursos',
                'description' => 'Visualiza {value} recursos diferentes',
                'values' => [5, 15, 30, 50, 100],
                'xp_rewards' => [75, 200, 400, 800, 1500],
                'icons' => ['📚', '📚📚', '📚📚📚', '📚📚📚📚', '📚📚📚📚📚']
            ],
            'EARLY_BIRD' => [
                'title' => 'Madrugador',
                'description' => 'Completa {value} actividades antes de tiempo',
                'values' => [1, 5, 10, 25, 50],
                'xp_rewards' => [100, 250, 500, 1000, 2000],
                'icons' => ['🌅', '🌅🌅', '🌅🌅🌅', '🌅🌅🌅🌅', '🌅🌅🌅🌅🌅']
            ],
            'STREAK_MASTER' => [
                'title' => 'Maestro de la Constancia',
                'description' => 'Mantén una racha de actividad de {value} días',
                'values' => [3, 7, 14, 30, 60],
                'xp_rewards' => [150, 300, 600, 1200, 2400],
                'icons' => ['🔥', '🔥🔥', '🔥🔥🔥', '🔥🔥🔥🔥', '🔥🔥🔥🔥🔥']
            ]
        ];
        
        // Crear logros normales para cada tipo
        foreach ($achievementTypes as $type => $config) {
            foreach ($config['values'] as $index => $value) {
                Achievement::updateOrCreate(
                    ['slug' => strtolower($type) . '_' . $value],
                    [
                        'title' => $config['title'] . ' ' . $config['icons'][$index],
                        'description' => str_replace('{value}', $value, $config['description']),
                        'icon' => $config['icons'][$index],
                        'xp_reward' => $config['xp_rewards'][$index],
                        'type' => $type,
                        'requirement_value' => $value,
                        'secret' => false
                    ]
                );
            }
        }

        // Crear algunos logros secretos
        $secretAchievements = [
            [
                'title' => 'Explorador Nocturno',
                'description' => 'Completa una actividad entre las 12 AM y las 4 AM',
                'icon' => '🌙',
                'xp_reward' => 500
            ],
            [
                'title' => 'Velocista',
                'description' => 'Completa un cuestionario en menos de 1 minuto con calificación perfecta',
                'icon' => '⚡',
                'xp_reward' => 1000
            ],
            [
                'title' => 'Sabio del Foro',
                'description' => 'Obtén 50 "me gusta" en tus respuestas del foro',
                'icon' => '👑',
                'xp_reward' => 1500
            ],
            [
                'title' => 'Maratón de Estudio',
                'description' => 'Completa 5 actividades diferentes en un solo día',
                'icon' => '🏃',
                'xp_reward' => 2000
            ]
        ];

        foreach ($secretAchievements as $achievement) {
            Achievement::updateOrCreate(
                ['slug' => Str::slug($achievement['title'])],
                array_merge($achievement, ['secret' => true])
            );
        }
    }
}
