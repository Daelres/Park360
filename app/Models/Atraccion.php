<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atraccion extends Model
{
    use HasFactory;

    protected $table = 'atraccion';

    protected $fillable = [
        'zona_id',
        'sede_id',
        'nombre',
        'descripcion',
        'tipo',
        'altura_minima',
        'capacidad',
        'estado_operativo',
        'ubicacion_gps',
        'imagen_url',
    ];

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function calendarios(): HasMany
    {
        return $this->hasMany(CalendarioAtraccion::class, 'atraccion_id');
    }

    public function estados(): HasMany
    {
        return $this->hasMany(EstadoAtraccion::class, 'atraccion_id');
    }

    public function lecturasCola(): HasMany
    {
        return $this->hasMany(LecturaCola::class, 'atraccion_id');
    }

    public function incidentes(): HasMany
    {
        return $this->hasMany(Incidente::class, 'atraccion_id');
    }

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'atractivo_id');
    }

    public function tareasOperativas(): HasMany
    {
        return $this->hasMany(TareaOperativa::class, 'atractivo_id');
    }
}
