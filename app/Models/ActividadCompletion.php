<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActividadCompletion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actividad_completions';

    protected $fillable = [
        'completable_type',
        'completable_id',
        'inscritos_id',
        'completed',
        'completed_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function completable()
    {
        return $this->morphTo();
    }

    public function inscrito()
    {
        return $this->belongsTo(Inscritos::class);
    }

    protected static function booted()
    {
        static::saved(function ($actividadCompletion) {
            $inscrito = $actividadCompletion->inscrito;
            if ($inscrito) {
                $inscrito->actualizarProgreso();
            }
        });
    }
}
