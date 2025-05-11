<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntentoCuestionario extends Model
{
    use HasFactory;
    protected $table = 'intentos_cuestionarios';
    protected $fillable = [
        'inscrito_id',
        'cuestionario_id',
        'intento_numero',
        'iniciado_en',
        'finalizado_en',
        'nota',
        'aprobado',
    ];

    protected $casts = [
        'iniciado_en' => 'datetime',
        'finalizado_en' => 'datetime',
        'aprobado' => 'boolean',
    ];
    public function respuestasEst() {
        return $this->hasMany(RespuestaEstudiante::class, 'intento_id');
    }

    public function cuestionario() {
        return $this->belongsTo(Cuestionario::class);
    }

    public function inscrito() {
        return $this->belongsTo(Inscritos::class, 'inscrito_id');
    }
}
