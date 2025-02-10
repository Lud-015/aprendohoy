<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subtema extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "subtemas";

    protected $fillable = ['titulo_subtema', 'descripcion', 'tema_id','imagen', 'orden'];

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function cuestionarios()
    {
        return $this->hasMany(Cuestionario::class);
    }

    public function completions()
    {
        return $this->hasMany(ActividadCompletion::class, 'completable_id')
            ->where('completable_type', Subtema::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tareas::class);
    }

    public function recursos()
    {
        return $this->hasMany(RecursoSubtema::class, 'subtema_id');
    }

    public function estaDesbloqueado($inscritoId)
    {
        // Si es el primer subtema, está desbloqueado por defecto
        if ($this->esPrimerSubtema()) {
            return true;
        }

        // Obtener el subtema anterior
        $subtemaAnterior = $this->obtenerSubtemaAnterior();

        // Si no hay subtema anterior, el subtema actual no está desbloqueado
        if (!$subtemaAnterior) {
            return false;
        }

        // Obtener las actividades completadas del subtema anterior
        $actividadesCompletadas = $subtemaAnterior->actividadesCompletadas($inscritoId);

        // Calcular el total de actividades en el subtema anterior
        $totalActividades = $subtemaAnterior->tareas()->count() + $subtemaAnterior->cuestionarios()->count();

        // Si no hay actividades, el subtema actual está desbloqueado por defecto
        if ($totalActividades === 0) {
            return true;
        }

        // Verificar si todas las actividades del subtema anterior están completadas
        return $actividadesCompletadas->count() === $totalActividades;
    }

    // Verificar si es el primer subtema
    public function esPrimerSubtema()
    {
        // Obtener el primer subtema del tema actual
        $primerSubtema = Subtema::where('tema_id', $this->tema_id)
            ->orderBy('orden', 'asc')
            ->first();

        // Si no hay subtemas o el subtema actual no tiene orden, devolver false
        if (!$primerSubtema || is_null($this->orden)) {
            return false;
        }

        // Verificar si el subtema actual es el primero
        return $this->orden === $primerSubtema->orden;
    }

    // Obtener el subtema anterior
    public function obtenerSubtemaAnterior()
    {
        return Subtema::where('tema_id', $this->tema_id)
            ->where('orden', '<', $this->orden)
            ->orderBy('orden', 'desc')
            ->first();
    }

    // Obtener las actividades completadas por un estudiante
    public function actividadesCompletadas($inscritoId)
    {
        // Obtener los IDs de tareas y cuestionarios
        $tareaIds = $this->tareas()->pluck('id');
        $cuestionarioIds = $this->cuestionarios()->pluck('id');

        // Combinar los IDs en una sola colección
        $completableIds = $tareaIds->merge($cuestionarioIds);

        // Definir los tipos de actividades
        $tiposActividades = [
            Cuestionario::class,
            Tareas::class,
        ];

        // Filtrar las actividades completadas
        return ActividadCompletion::whereIn('completable_id', $completableIds)
            ->whereIn('completable_type', $tiposActividades)
            ->where('inscritos_id', $inscritoId)
            ->where('completed', true)
            ->get();
    }













}
