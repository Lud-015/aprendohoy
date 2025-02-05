<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cursos extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;


    public function nivel(): BelongsTo
    {
        return $this->belongsTo(Nivel::class, 'niveles_id');
    }

    public function docente(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function edad_dirigida():BelongsTo
    {
        return $this->belongsTo(EdadDirigida::class, 'edadDir_id');
    }
    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'curso_horarios');
    }
    public function inscritos(): HasMany
    {
        return $this->hasMany(Inscritos::class,  'id' , 'estudiante_id');
    }
    public function foros(): HasMany
    {
        return $this->hasMany(Foro::class,  'id' , 'cursos_id');
    }

    public function recursos(): HasMany
    {
        return $this->hasMany(Recursos::class,  'id' , 'cursos_id');
    }
    public function asistencia(): HasMany
    {
        return $this->hasMany(Asistencia::class,  'id' , 'curso_id');
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tareas::class,  'id' , 'curso_id');
    }
    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluaciones::class,  'id' , 'curso_id');
    }

    public function temas()
    {
        return $this->hasMany(Tema::class, 'curso_id'); // Asegura que el campo sea correcto
    }







}
