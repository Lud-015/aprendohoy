<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    public function routeNotificationForMail()
    {
        return $this->email; // Devuelve el correo electrónico del estudiante
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname1',
        'lastname2',
        'CI',
        'Celular',
        'fechadenac',
        'PaisReside',
        'CiudadReside',
        'email',
        'password',
        'avatar',
        'cv_file', 
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

    protected $softDeletes = true;

    public function age()
    {
        return Carbon::parse($this->attributes['fechadenac'])->age;
    }


    public function atributosDocente(): HasOne
    {
        return $this->hasOne(AtributosDocente::class, 'docente_id');
    }


    public function tutor(): HasOne
    {
        return $this->hasOne(TutorRepresentanteLegal::class, 'estudiante_id');
    }

    public function inscritos(): HasMany
    {
        return $this->hasMany(Inscritos::class, 'estudiante_id', 'id');
    }

    public function foromensaje(): HasMany
    {
        return $this->hasMany(ForoMensaje::class, 'estudiante_id');
    }

    public function entregatarea(): HasMany
    {
        return $this->hasMany(TareasEntrega::class, 'estudiante_id');
    }

    public function entregaevaluacion(): HasMany
    {
        return $this->hasMany(EvaluacionEntrega::class, 'estudiante_id');
    }



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->inscritos()->get()->each->delete();
            $user->foromensaje()->delete();
            $user->entregatarea()->delete();
            $user->entregaevaluacion()->delete();
        });

        static::restoring(function ($user) {
            $user->inscritos()->onlyTrashed()->get()->each(function ($inscrito) {
                $inscrito->restore();
                $inscrito->asistencia()->onlyTrashed()->get()->each->restore();
                $inscrito->notatarea()->onlyTrashed()->get()->each->restore();
                $inscrito->notaevaluacion()->onlyTrashed()->get()->each->restore();
                $inscrito->boletines()->onlyTrashed()->get()->each->restore();
            });
            $user->foromensaje()->restore();
            $user->entregatarea()->restore();
            $user->entregaevaluacion()->restore();
            // Agrega más relaciones aquí si es necesario
        });
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
