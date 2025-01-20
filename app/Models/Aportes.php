<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aportes extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;
    /**
     * Get the user that owns the Aportes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($aporte) {
            // Puedes agregar lógica de eliminación suave en cascada aquí si hay relaciones adicionales.
        });

        static::restoring(function ($aporte) {
            // Puedes agregar lógica de restauración suave aquí si es necesario.
        });
    }



}
