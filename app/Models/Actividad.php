<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    use HasFactory;

    protected $table = 'actividades';
    protected $fillable = [
        'subtema_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_limite',
        'orden',
        'es_publica',
        'es_obligatoria',
        'tipo_actividad_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_limite' => 'datetime',
    ];

    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id');
    }
    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'tipo_actividad_id');
    }

    public function tiposEvaluacion()
    {
        return $this->belongsToMany(TipoEvaluacion::class, 'actividad_tipos_evaluacion')
            ->withPivot('puntaje_maximo', 'es_obligatorio')
            ->withTimestamps();
    }
    public function intentosCuestionario()
    {
        return $this->hasMany(IntentoCuestionario::class);
    }

    public function tipoEvaluacion()
    {
        return $this->belongsTo(TipoEvaluacion::class);
    }
    public function tipoEvaluacionActividad()
    {
        return $this->hasMany(TipoEvaluacionActividad::class);
    }


    public function cuestionario()
    {
        return $this->hasOne(Cuestionario::class);
    }

    public function entregas()
    {
        return $this->hasMany(EntregaArchivo::class);
    }

    public function completions()
    {
        return $this->morphMany(ActividadCompletion::class, 'completable');
    }
    public function isCompletedByInscrito($inscritoId)
    {
        return $this->completions()
            ->where('inscritos_id', $inscritoId)
            ->where('completed', true)
            ->exists();
    }
}
