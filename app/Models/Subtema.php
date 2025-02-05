<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subtema extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "subtemas";

    protected $fillable = ['titulo_subtema', 'descripcion', 'tema_id','imagen'];

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function cuestionarios()
    {
        return $this->hasMany(Cuestionario::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tareas::class);
    }

    public function recursos()
    {
        return $this->hasMany(RecursoSubtema::class, 'subtema_id');
    }

    public function isDisponible()
{
    return !$this->bloqueado;
}






}
