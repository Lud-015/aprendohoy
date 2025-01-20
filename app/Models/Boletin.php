<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boletin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "boletin";
    protected $softDelete = true;
    protected $fillable = ['id', 'nota_final', 'comentario_boletin', 'inscripcion'];


    public function incripcion(): BelongsTo
    {
        return $this->belongsTo(Inscritos::class, 'id' ,'inscripcion_id');

    }

    public function notasBoletin(): HasMany
    {
        return $this->hasMany(Notas_Boletin::class, 'boletin_id');
    }

}
