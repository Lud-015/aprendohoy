<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Primer Paso',
                'description' => 'Completa tu primera actividad en cualquier curso',
                'icon' => '🎯',
                'type' => 'ACTIVITY_COMPLETION',
                'requirement_value' => 1,
                'xp_reward' => 50,
                'is_secret' => false,
            ],
            [
                'title' => 'Estudiante Dedicado',
                'description' => 'Completa 10 actividades en total',
                'icon' => '📚',
                'type' => 'ACTIVITY_COMPLETION',
                'requirement_value' => 10,
                'xp_reward' => 100,
                'is_secret' => false,
            ],
            [
                'title' => 'Participante Activo',
                'description' => 'Participa en 5 foros diferentes',
                'icon' => '💬',
                'type' => 'FORUM_PARTICIPATION',
                'requirement_value' => 5,
                'xp_reward' => 75,
                'is_secret' => false,
            ],
            [
                'title' => 'Maestro del Conocimiento',
                'description' => 'Obtén una calificación perfecta en un cuestionario',
                'icon' => '🏆',
                'type' => 'PERFECT_QUIZ',
                'requirement_value' => 1,
                'xp_reward' => 100,
                'is_secret' => false,
            ],
            [
                'title' => 'Racha Imparable',
                'description' => 'Mantén una racha de actividad de 7 días',
                'icon' => '🔥',
                'type' => 'STREAK',
                'requirement_value' => 7,
                'xp_reward' => 150,
                'is_secret' => false,
            ],
            [
                'title' => 'Explorador de Recursos',
                'description' => 'Accede a 20 recursos diferentes',
                'icon' => '🔍',
                'type' => 'RESOURCE_ACCESS',
                'requirement_value' => 20,
                'xp_reward' => 80,
                'is_secret' => false,
            ],
            [
                'title' => 'Puntualidad Perfecta',
                'description' => 'Entrega 5 tareas antes de la fecha límite',
                'icon' => '⏰',
                'type' => 'EARLY_SUBMISSION',
                'requirement_value' => 5,
                'xp_reward' => 100,
                'is_secret' => false,
            ],
            [
                'title' => 'Primer Certificado',
                'description' => 'Obtén tu primer certificado de curso completado',
                'icon' => '📜',
                'type' => 'CERTIFICATE_EARNED',
                'requirement_value' => 1,
                'xp_reward' => 200,
                'is_secret' => false,
            ],
            [
                'title' => 'Colaborador Estrella',
                'description' => '¡Logro secreto! Ayuda a otros estudiantes en los foros',
                'icon' => '⭐',
                'type' => 'HELPFUL_RESPONSES',
                'requirement_value' => 10,
                'xp_reward' => 150,
                'is_secret' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
} 