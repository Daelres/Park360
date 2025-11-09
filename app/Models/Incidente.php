<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incidente extends Model
{
    use HasFactory;

    protected $table = 'incidente';

    protected $fillable = [
        'atraccion_id',
        'reportado_por_id',
        'tipo',
        'severidad',
        'descripcion',
        'inicio_at',
        'fin_at',
        'estado',
    ];

    protected $casts = [
        'inicio_at' => 'datetime',
        'fin_at' => 'datetime',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atraccion_id');
    }

    public function reportadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'reportado_por_id');
    }
}
