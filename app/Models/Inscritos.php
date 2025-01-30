<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Inscritos extends Model
{
    use HasFactory, SoftDeletes;

    protected $softDelete = true;

    public function estudiantes(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function cursos(): BelongsTo
    {
        return $this->belongsTo(Cursos::class, 'cursos_id');
    }

    public function asistencia(): HasMany
    {
        return $this->hasMany(Asistencia::class,  'inscripcion_id');
    }

    public function notatarea(): HasMany
    {
        return $this->hasMany(NotaEntrega::class, 'inscripcion_id');
    }

    public function notaevaluacion(): HasMany
    {
        return $this->hasMany(NotaEvaluacion::class, 'inscripcion_id');
    }
    public function boletines(): HasMany
    {
        return $this->hasMany(Boletin::class,  'inscripcion_id');
    }

    public function certificado()
    {
        return $this->hasOne(Certificado::class, 'inscrito_id');
    }

    // Configuración para soft deletes en cascada
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($inscrito) {
            $inscrito->asistencia()->delete();
            $inscrito->notatarea()->delete();
            $inscrito->notaevaluacion()->delete();
            $inscrito->boletines()->delete();
        });

        static::restoring(function ($inscrito) {
            $inscrito->asistencia()->restore();
            $inscrito->notatarea()->restore();
            $inscrito->notaevaluacion()->restore();
            $inscrito->boletines()->restore();
        });
    }
}
