<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Level;
use App\Models\UserXP;
use App\Models\Inscritos;
use App\Models\Cursos;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Verificamos si el usuario tiene una inscripción activa
        $inscrito = Inscritos::where('estudiante_id', $user->id)
                            ->where('estado', 'activo')
                            ->first();
        
        if (!$inscrito) {
            // Si no hay inscripción, mostramos una vista alternativa
            return view('profile.no-achievements', [
                'message' => 'No estás inscrito en ningún curso o congreso',
                'suggestion' => 'Para acceder al sistema de logros, necesitas inscribirte en al menos un curso o congreso.'
            ]);
        }
        
        // Si hay inscripción, continuamos con la lógica normal
        $userXP = $user->userXP;
        
        // Si no tiene XP inicializado, establecemos valores por defecto
        if (!$userXP) {
            $userXP = new UserXP();
            $userXP->inscrito_id = $inscrito->id;
            $userXP->current_xp = 0;
            $userXP->current_level = 1;
            $userXP->save();
            
            $user->userXP = $userXP;
        }
        
        // Obtener nivel actual y siguiente
        $currentLevel = Level::getCurrentLevel($userXP->current_xp);
        $nextLevel = $currentLevel ? $currentLevel->nextLevel() : null;
        
        // Calcular progreso
        $currentXP = $userXP->current_xp - ($currentLevel ? $currentLevel->required_xp : 0);
        $nextLevelXP = $nextLevel ? $nextLevel->required_xp - ($currentLevel ? $currentLevel->required_xp : 0) : 100;
        $progressPercentage = $nextLevelXP > 0 ? min(($currentXP / $nextLevelXP) * 100, 100) : 0;

        // Obtener logros con manejo de nulos
        $achievements = Achievement::with(['users' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get()->map(function($achievement) use ($user) {
            $achievement->isUnlocked = $achievement->isUnlockedBy($user);
            $achievement->progress = $this->calculateProgress($achievement, $user);
            return $achievement;
        });

        // Estadísticas con valores por defecto
        $unlockedAchievements = $achievements->where('isUnlocked', true)->count();
        $totalAchievements = $achievements->count();
        $currentStreak = $this->calculateCurrentStreak($user);
        
        // Obtener todos los niveles
        $levels = Level::orderBy('level_number')->get();

        return view('profile.achievements', compact(
            'currentLevel',
            'nextLevel',
            'currentXP',
            'nextLevelXP',
            'progressPercentage',
            'achievements',
            'unlockedAchievements',
            'totalAchievements',
            'currentStreak',
            'levels',
            'userXP'
        ));
    }

    private function calculateProgress($achievement, $user)
    {
        // Aquí implementarías la lógica específica para calcular el progreso
        // basado en el tipo de logro
        switch($achievement->type) {
            case 'QUIZ_MASTER':
                return $user->perfectQuizzes()->count();
            case 'FORUM_CONTRIBUTOR':
                return $user->forumPosts()->count();
            case 'RESOURCE_EXPLORER':
                return $user->viewedResources()->count();
            case 'EARLY_BIRD':
                return $user->earlyCompletions()->count();
            case 'STREAK_MASTER':
                return $this->calculateCurrentStreak($user);
            default:
                return 0;
        }
    }

    private function calculateCurrentStreak($user)
    {
        // Aquí implementarías la lógica para calcular la racha actual
        // basado en la actividad del usuario
        $lastActivity = $user->userXP->last_activity_at;
        if (!$lastActivity) {
            return 0;
        }

        $streak = 1;
        $currentDate = now()->subDay();

        while ($lastActivity && $lastActivity->isToday() || $lastActivity->isYesterday()) {
            $streak++;
            $currentDate = $currentDate->subDay();
            $lastActivity = $user->activities()
                ->whereDate('created_at', $currentDate)
                ->latest()
                ->first();
        }

        return $streak;
    }
} 