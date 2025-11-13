<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'estado',
        'ultimo_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ultimo_login' => 'datetime',
        ];
    }

    /**
     * Accessor to keep backward compatibility with legacy nombre attribute.
     */
    public function getNombreAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Mutator used when legacy code sets the nombre attribute.
     */
    public function setNombreAttribute(?string $value): void
    {
        $this->attributes['name'] = $value;
    }

    public function sesionesSSO(): HasMany
    {
        return $this->hasMany(SesionSSO::class, 'user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'user_rol', 'user_id', 'rol_id')->withTimestamps();
    }

    public function empleado(): HasOne
    {
        return $this->hasOne(Empleado::class, 'user_id');
    }

    public function preferenciasNotificacion(): HasMany
    {
        return $this->hasMany(PreferenciaNotificacion::class, 'user_id');
    }

    public function estadosAtraccionRegistrados(): HasMany
    {
        return $this->hasMany(EstadoAtraccion::class, 'registrado_por_id');
    }

    public function incidentesReportados(): HasMany
    {
        return $this->hasMany(Incidente::class, 'reportado_por_id');
    }

    public function mantenimientosResponsable(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'responsable_user_id');
    }

    public function tareasAsignadas(): HasMany
    {
        return $this->hasMany(TareaOperativa::class, 'asignada_a_user_id');
    }
}
