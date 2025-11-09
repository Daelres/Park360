<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento';

    protected $fillable = [
        'atractivo_id',
        'tipo',
        'inicio_programado',
        'fin_programado',
        'inicio_real',
        'fin_real',
        'responsable',
        'estado',
    ];

    protected $casts = [
        'inicio_programado' => 'date',
        'fin_programado' => 'date',
        'inicio_real' => 'date',
        'fin_real' => 'date',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atractivo_id');
    }

    public function responsableUsuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'responsable');
    }
}
