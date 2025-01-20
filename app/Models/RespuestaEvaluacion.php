<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespuestaEvaluacion extends Model
{
    use HasFactory, SoftDeletes;

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(PreguntaEvaluacion::class);

    }
}
