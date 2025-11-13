<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'email',
        'nombre',
        'estado',
        'ultimo_login',
    ];

    protected $casts = [
        'ultimo_login' => 'datetime',
    ];

    public function sesionesSSO(): HasMany
    {
        return $this->hasMany(SesionSSO::class, 'usuario_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'user_rol', 'usuario_id', 'rol_id')->withTimestamps();
    }

    public function empleado(): HasOne
    {
        return $this->hasOne(Empleado::class, 'usuario_id');
    }

    public function preferenciasNotificacion(): HasMany
    {
        return $this->hasMany(PreferenciaNotificacion::class, 'usuario_id');
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
        return $this->hasMany(Mantenimiento::class, 'responsable');
    }

    public function tareasAsignadas(): HasMany
    {
        return $this->hasMany(TareaOperativa::class, 'asignada_a');
    }
}
