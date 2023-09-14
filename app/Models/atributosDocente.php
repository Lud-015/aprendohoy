<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class atributosDocente extends Model
{
    use HasFactory, SoftDeletes;

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

}
