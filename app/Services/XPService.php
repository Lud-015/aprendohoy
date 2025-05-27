<?php

namespace App\Services;

use App\Models\UserXP;
use App\Models\Inscritos;
use Illuminate\Support\Facades\Cache;

class XPService
{
    protected $xpActions = [
        'complete_activity' => 50,
        'perfect_quiz' => 100,
        'forum_participation' => 25,
        'help_others' => 30,
        'daily_login' => 10,
        'resource_view' => 5,
        'early_submission' => 20
    ];

    protected $multipliers = [
        'weekend' => 1.5,
        'streak' => 1.2,
        'first_daily' => 1.1
    ];

    public function awardXP(Inscritos $inscrito, string $action, array $context = [])
    {
        if (!isset($this->xpActions[$action])) {
            throw new \InvalidArgumentException("Acción de XP no válida: {$action}");
        }

        $baseXP = $this->xpActions[$action];
        $multiplier = $this->calculateMultiplier($inscrito);
        $finalXP = round($baseXP * $multiplier);

        $userXP = UserXP::firstOrCreate(
            ['inscrito_id' => $inscrito->id],
            [
                'current_xp' => 0,
                'total_xp_earned' => 0,
                'current_level' => 1,
                'last_activity_at' => now()
            ]
        );

        $userXP->addXP($finalXP);

        // Invalidar caché relacionada
        $this->invalidateUserCache($inscrito->id);

        return $finalXP;
    }

    protected function calculateMultiplier(Inscritos $inscrito)
    {
        $finalMultiplier = 1;

        // Multiplicador de fin de semana
        if (now()->isWeekend()) {
            $finalMultiplier *= $this->multipliers['weekend'];
        }

        // Multiplicador de racha
        if ($this->hasLoginStreak($inscrito)) {
            $finalMultiplier *= $this->multipliers['streak'];
        }

        // Multiplicador de primera actividad del día
        if ($this->isFirstDailyActivity($inscrito)) {
            $finalMultiplier *= $this->multipliers['first_daily'];
        }

        return $finalMultiplier;
    }

    protected function hasLoginStreak(Inscritos $inscrito)
    {
        $key = "user_login_streak:{$inscrito->id}";
        return Cache::get($key, 0) >= 7;
    }

    protected function isFirstDailyActivity(Inscritos $inscrito)
    {
        $userXP = UserXP::where('inscrito_id', $inscrito->id)->first();
        
        if (!$userXP || !$userXP->last_activity_at) {
            return true;
        }

        return !$userXP->last_activity_at->isToday();
    }

    protected function invalidateUserCache($inscritoId)
    {
        $cacheKeys = [
            "user_xp:{$inscritoId}",
            "user_level:{$inscritoId}",
            "user_achievements:{$inscritoId}"
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
} 