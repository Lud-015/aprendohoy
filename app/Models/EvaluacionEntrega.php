<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluacionEntrega extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluaciones_entregas';
    protected $softDelete = true;

    public function estudiantes(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Tareas::class);
    }
}
