<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cursos extends Model
{
    use HasFactory, SoftDeletes;

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'niveles_id');
    }

    public function docente()
    {
        return $this->belongsTo(User::class);
    }

    public function edad_dirigida()
    {
        return $this->belongsTo(EdadDirigida::class, 'edadDir_id');
    }
    public function horarios()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }
    public function inscritos()
    {
        return $this->hasMany(Inscritos::class,  'id' , 'estudiante_id');
    }
    public function foros()
    {
        return $this->hasMany(Foro::class,  'id' , 'cursos_id');
    }
}
