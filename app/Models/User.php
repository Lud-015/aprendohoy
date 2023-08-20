<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasRoles,HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'appaterno',
        'apmaterno',
        'CI',
        'Celular',
        'fechadenac',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
    ];

    public function atributosdocente(){
        return $this->hasOne(AtributosDocentes::class, 'id' , 'docente_id');
    }   

    public function representanteLegal(){
        return $this->hasOne(TutorRepresentanteLegal::class, 'id' , 'estudiante_id');
    }   


}
