<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaEvaluacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    protected $table = 'nota_evaluaciones';

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluaciones::class, 'evaluaciones_id');
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscritos::class, 'inscripcion_id');
    }

}
