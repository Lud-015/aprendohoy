<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Nivel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nivel';

    protected $fillable = [
        'name',
    ];


    public function cursos()

    {
        return $this->hasOne(Cursos::class, 'nivel_id' , 'id');
    }


}
