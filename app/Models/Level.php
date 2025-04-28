<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';

    protected $fillable = [
        'level_number',
        'required_xp'
    ];

    public static function getNextLevel($currentXp)
    {
        return self::where('required_xp', '>', $currentXp)
            ->orderBy('required_xp', 'asc')
            ->first();
    }

    public static function getCurrentLevel($currentXp)
    {
        return self::where('required_xp', '<=', $currentXp)
            ->orderBy('required_xp', 'desc')
            ->first();
    }
}
