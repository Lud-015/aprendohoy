<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Achievement extends Model
{
    protected $table = 'achievements';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'xp_reward'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withTimestamps();
    }

    public static function createWithSlug(array $data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return static::create($data);
    }
}
