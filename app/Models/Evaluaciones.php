<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Evaluaciones extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    public function cursos() :BelongsTo

    {

        return $this->belongsTo(Cursos::class, 'cursos_id');

    }

    public function notaevaluacion(): HasMany
    {
        return $this->hasMany(NotaEvaluacion::class, 'evaluaciones_id');
    }

    public function preguntaevaluacion(): HasMany
    {
        return $this->hasMany(PreguntaEvaluacion::class, 'evaluacion_id');
    }

    public function entregaevaluacion(): HasMany
    {
        return $this->hasMany(EvaluacionEntrega::class, 'evaluaciones_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($evaluacion) {
            $evaluacion->notaevaluacion()->delete();
        });

        static::restoring(function ($evaluacion) {
            $evaluacion->notaevaluacion()->restore();
        });
    }

}
