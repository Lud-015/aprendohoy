<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaEntrega extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;

    
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tareas::class, 'tarea_id');
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscritos::class, 'inscripcion_id');
    }

}
