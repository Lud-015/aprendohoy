<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreguntaEvaluacion extends Model
{
    use HasFactory, SoftDeletes;

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluaciones::class, 'id' ,'evaluacion_id');

    }

    public function preguntas(): HasMany
    {
        return $this->hasMany(RespuestaEvaluacion::class);

    }
}
