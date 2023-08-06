<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;

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
}
