<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Inscritos extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'progreso',
        'completado'
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


    public static function desbloquearSiguienteSubtema($inscritoId, $subtemaId)
    {
        $subtemaActual = Subtema::findOrFail($subtemaId);

        // Verificar si el subtema actual ya está completado
        if (!$subtemaActual->estaCompletado($inscritoId)) {
            return;
        }

        // Marcar el subtema como completado en la tabla intermedia
        DB::table('subtema_inscritos')
            ->where('inscrito_id', $inscritoId)
            ->where('subtema_id', $subtemaId)
            ->update(['completado' => true]);

        // Buscar el siguiente subtema del mismo tema
        $siguienteSubtema = Subtema::where('tema_id', $subtemaActual->tema_id)
            ->where('id', '>', $subtemaActual->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($siguienteSubtema) {
            // Crear un registro en subtema_inscritos para desbloquearlo
            DB::table('subtema_inscritos')->updateOrInsert([
                'inscrito_id' => $inscritoId,
                'subtema_id' => $siguienteSubtema->id
            ], [
                'completado' => false
            ]);
        }

        // Actualizar el progreso general
        $inscrito = Inscritos::find($inscritoId);
        $inscrito->actualizarProgreso();
    }


}
