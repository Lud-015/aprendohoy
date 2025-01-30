<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Tareas extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    public function cursos() :BelongsTo

    {

        return $this->belongsTo(Cursos::class, 'cursos_id');

    }


    public function subtema()
    {
        return $this->belongsTo(Subtema::class);
    }




    public function entregatarea(): HasMany
    {
        return $this->hasMany(TareasEntrega::class, 'tarea_id');
    }


    public function notatarea(): HasMany
    {
        return $this->hasMany(NotaEntrega::class, 'tarea_id');
    }

    public function preguntatarea(): HasMany
    {
        return $this->hasMany(PreguntaTarea::class, 'tarea_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tarea) {
            // Eliminar lógicamente relaciones al eliminar la tarea
            $tarea->notatarea()->delete();
        });

        static::restoring(function ($tarea) {
            // Restaurar lógicamente relaciones al restaurar la tarea
            $tarea->notatarea()->restore();
        });
    }
}
