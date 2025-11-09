<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstadoAtraccion extends Model
{
    use HasFactory;

    protected $table = 'estado_atraccion';

    protected $fillable = [
        'atraccion_id',
        'estado',
        'desde',
        'hasta',
        'motivo',
        'registrado_por_id',
    ];

    protected $casts = [
        'desde' => 'datetime',
        'hasta' => 'datetime',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atraccion_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'registrado_por_id');
    }
}
