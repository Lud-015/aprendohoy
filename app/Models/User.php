<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function atributosDocente(){
        return $this->hasOne(atributosDocente::class, 'id' , 'docente_id');
    }

    public function representanteLegal(){
        return $this->hasOne(TutorRepresentanteLegal::class, 'id' , 'estudiante_id');
    }

    public function inscritos(): HasMany
    {
        return $this->hasMany(Inscritos::class, 'estudiante_id' , 'id');
    }


    /**
 * Accessor for Age.
 */
public function age()
{
    return Carbon::parse($this->attributes['fechadenac'])->age;
}



public function foromensaje(): HasMany
{
    return $this->hasMany(ForoMensaje::class, 'estudiante_id');
}

}
