<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserXp extends Model
{
    protected $table = 'user_xps';

    protected $fillable = [
        'users_id',
        'curso_id',
        'xp',
        'level',
        'last_earned_at'
    ];

    protected $casts = [
        'last_earned_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id');
    }
}
