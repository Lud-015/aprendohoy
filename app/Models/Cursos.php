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


    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluaciones::class,  'id' , 'curso_id');
    }

    public function temas()
    {
        return $this->hasMany(Tema::class, 'curso_id'); // Asegura que el campo sea correcto
    }
    public function calcularProgreso($inscrito_id)
    {
        // Obtener el registro del inscrito
        $inscrito = Inscritos::find($inscrito_id);

        if (!$inscrito) {
            throw new \Exception("Inscrito no encontrado.");
        }

        // Obtener todos los subtemas de los temas del curso
        $subtemas = $this->temas->flatMap(fn($tema) => $tema->subtemas);

        // Obtener todas las actividades (tareas + cuestionarios) de los subtemas
        $actividades = $subtemas->flatMap(fn($subtema) =>
            $subtema->tareas->pluck('id')->merge($subtema->cuestionarios->pluck('id'))
        );

        $totalActividades = $actividades->count();

        if ($totalActividades === 0) {
            $progreso = 0; // Evita división por cero
        } else {
            // Contar actividades completadas por el estudiante
            $completadas = ActividadCompletion::where('inscritos_id', $inscrito_id)
                ->whereIn('completable_id', $actividades)
                ->count();

            // Calcular el progreso
            $progreso = round(($completadas / $totalActividades) * 100, 2);
        }

        // Actualizar la columna `progreso` en la tabla `inscritos`
        $inscrito->progreso = $progreso;
        $inscrito->save();

        return $progreso;
    }








}
