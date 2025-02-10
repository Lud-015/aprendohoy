<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Tema extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "temas";

    protected $fillable = ['titulo_tema', 'descripcion','imagen','curso_id', 'orden'];

    public function subtemas()
    {
        return $this->hasMany(Subtema::class,'tema_id','id');
    }
    public function curso()
{
    return $this->belongsTo(Cursos::class, 'curso_id'); // Asegura que el campo sea correcto
}




public function estaDesbloqueado($inscritoId)
{
    if ($this->esPrimerTema()) {
        return true;
    }

    // Obtener el tema anterior
    $temaAnterior = $this->obtenerTemaAnterior();



    if ($temaAnterior) {
        $subtemasCompletados = $temaAnterior->subtemaCompletados($inscritoId);
        $totalSubtemas = $temaAnterior->subtemas()->count();
        return $subtemasCompletados >= $totalSubtemas && $totalSubtemas > 0;
    }

    return false;
}



// Verificar si es el primer tema
public function esPrimerTema()
{
    return $this->orden === Tema::where('curso_id', $this->curso_id)
        ->orderBy('orden', 'asc')
        ->value('orden'); // Devuelve el menor "orden" dentro del curso
}

// Obtener el tema anterior
public function obtenerTemaAnterior()
{
    return Tema::where('curso_id', $this->curso_id)
        ->where('orden', '<', $this->orden)
        ->orderBy('orden', 'desc')
        ->first();
}

    // Contar subtemas completados
    public function subtemaCompletados($inscritoId)
    {
        $completados = 0;

        foreach ($this->subtemas as $subtema) {
            if ($subtema->estaDesbloqueado($inscritoId)) {
                $completados++;
            }
        }

        return $completados;
    }











}
