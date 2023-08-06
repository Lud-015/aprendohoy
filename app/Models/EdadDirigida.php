<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdadDirigida extends Model
{
    use HasFactory;


    public function cursos()
    {
        return $this->hasOne(Cursos::class, 'edadDir_id', 'id');
    }



}
