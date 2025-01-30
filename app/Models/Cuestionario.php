<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuestionario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titulo_cuestionario',
        'descripcion',
        'fecha_habilitacion',
        'fecha_vencimiento',
        'puntos',
        'subtema_id'
    ];

    /**
     * Relación con el subtema.
     */
    public function subtema()
    {
        return $this->belongsTo(Subtema::class);
    }

    /**
     * Relación con las preguntas del cuestionario.
     */
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}
