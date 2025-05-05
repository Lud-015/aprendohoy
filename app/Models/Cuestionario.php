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


    public function cuestionario()
    {
        return $this->belongsTo(Cuestionario::class, 'cuestionario_id');
    }
    /**
     * Relación con el subtema.
     */
    public function subtema()
    {
        return $this->belongsTo(Subtema::class);
    }

    public function actividad() {
        return $this->belongsTo(Actividad::class);
    }

    public function preguntas() {
        return $this->hasMany(Pregunta::class);
    }

    public function intentos() {
        return $this->hasMany(IntentoCuestionario::class);
    }


    // Relación polimórfica con completions
    public function completions()
    {
        return $this->morphMany(ActividadCompletion::class, 'completable');
    }

    public function actividadCompletions()
    {
        return $this->hasMany(ActividadCompletion::class, 'completable_id')
            ->where('completable_type', self::class);
    }

    // Verificar si está completada por un usuario
    public function isCompletedByInscrito($inscritosId)
    {
        return $this->completions()
            ->where('inscritos_id', $inscritosId)
            ->where('completed', true)
            ->exists();
    }

    public function evaluaciones()
    {
        return $this->belongsToMany(Evaluaciones::class, 'cuestionario_evaluacion', 'cuestionario_id', 'evaluacion_id');
    }
}
