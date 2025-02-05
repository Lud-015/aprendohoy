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


    protected $fillable = [
        'progreso', 'completado'
    ];
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

    public function actividadCompletions()
    {
        return $this->hasMany(ActividadCompletion::class, 'inscritos_id');
    }


    public function actualizarProgreso()
    {
        $curso = $this->cursos;
        $total_actividades = 0;
        $actividades_completadas = 0;

        foreach ($curso->temas as $tema) {
            foreach ($tema->subtemas as $subtema) {
                $total_actividades += $subtema->tareas->count() + $subtema->cuestionarios->count();

                foreach ($subtema->tareas as $tarea) {
                    if ($tarea->isCompletedByInscrito($this->id)) {
                        $actividades_completadas++;
                    }
                }

                foreach ($subtema->cuestionarios as $cuestionario) {
                    if ($cuestionario->isCompletedByInscrito($this->id)) {
                        $actividades_completadas++;
                    }
                }
            }
        }

        // Calcular progreso
        $this->progreso = $total_actividades > 0
            ? ($actividades_completadas * 100) / $total_actividades
            : 0;

        $this->completado = $this->progreso >= 100;

        dd([
            'total_actividades' => $total_actividades,
            'actividades_completadas' => $actividades_completadas,
            'progreso' => $this->progreso,
            'completado' => $this->completado
        ]);

        // Guardar en la base de datos
        $this->save();
    }

}
