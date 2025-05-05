<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntentoCuestionario extends Model
{
    public function respuestas() {
        return $this->hasMany(RespuestaEstudiante::class, 'intento_id');
    }

    public function cuestionario() {
        return $this->belongsTo(Cuestionario::class);
    }

    public function estudiante() {
        return $this->belongsTo(Inscritos::class, 'inscritos_id');
    }
}
