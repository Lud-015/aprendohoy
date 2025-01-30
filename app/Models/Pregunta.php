<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pregunta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cuestionario_id',
        'pregunta',
        'tipo',
        'puntos'
    ];

    /**
     * Relación con el cuestionario.
     */
    public function cuestionario()
    {
        return $this->belongsTo(Cuestionario::class, 'cuestionario_id');
    }

    /**
     * Relación con las opciones de respuesta (si aplica).
     */
    public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }
}
