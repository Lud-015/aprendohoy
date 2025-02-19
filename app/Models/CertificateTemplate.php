<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['curso_id', 'template_front_path', 'template_back_path'];
    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id','id');
    }
}
