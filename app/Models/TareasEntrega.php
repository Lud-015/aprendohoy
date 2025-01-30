<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareasEntrega extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "entregas_tareas";

    protected $softDelete = true;
    public function estudiantes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tareas::class, 'tarea_id');
    }
}
