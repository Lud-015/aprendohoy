<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespuestaTareas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pregunta_id', 'texto_respuesta', 'es_correcta'
    ];


    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(PreguntaTarea::class, 'pregunta_id', 'id');

    }

}
