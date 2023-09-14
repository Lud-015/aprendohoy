<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorRepresentanteLegal extends Model
{
    use HasFactory, SoftDeletes;

    public function estudianteMenor(){

        return $this->belongsTo(User::class, 'estudiante_id');

    }
}
