<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model {

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

    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id');
    }
    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'tipo_actividad_id');
    }


    public function cuestionario() {
        return $this->hasOne(Cuestionario::class);
    }

    public function entregas() {
        return $this->hasMany(EntregaArchivo::class);
    }
}