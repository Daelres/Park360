<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleado';

    protected $fillable = [
        'usuario_id',
        'documento',
        'cargo',
        'area',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function turnos(): HasMany
    {
        return $this->hasMany(Turno::class, 'empleado_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'empleado_id');
    }

    public function accesosRegistrados(): HasMany
    {
        return $this->hasMany(CheckIn::class, 'acceso_por_id');
    }
}
