<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreguntaTarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tarea_id', 'tipo_preg', 'texto_pregunta', 'puntos'
    ];

    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tareas::class, 'id' ,'tarea_id');

    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(RespuestaTareas::class, 'pregunta_id');

    }
}
