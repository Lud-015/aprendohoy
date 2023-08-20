<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorRepresentanteLegal extends Model
{
    use HasFactory;

    public function estudianteMenor(){
    
        return $this->belongsTo(User::class, 'estudiante_id');
    
    }
}
