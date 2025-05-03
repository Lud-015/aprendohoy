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

    protected $table = "evaluaciones";

    protected $fillable = [
        'titulo_evaluacion',
        'descripcionEvaluacion',
        'fecha_habilitacion',
        'fecha_vencimiento',
        'puntos',
        'archivoEvaluacion',
        'es_cuestionario',
        'intentos_permitidos',
        'cuestionario_id',
    ];

    public function cuestionario()
{
    return $this->belongsTo(Cuestionario::class, 'cuestionario_id');
}

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
    public function tema(): BelongsTo
        {
            return $this->belongsTo(Temas::class, 'tema_id');
        }


}
