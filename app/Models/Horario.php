<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;

    public function cursos()
    {
        return $this->hasOne(Cursos::class, 'horario_id', 'id');
    }
}
