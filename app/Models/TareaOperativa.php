<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaOperativa extends Model
{
    use HasFactory;

    protected $table = 'tarea_operativa';

    protected $fillable = [
        'atractivo_id',
        'asignada_a',
        'titulo',
        'prioridad',
        'estado',
        'sla_horas',
        'origen',
        'vencimiento_at',
    ];

    protected $casts = [
        'vencimiento_at' => 'date',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atractivo_id');
    }

    public function asignadoA(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'asignada_a');
    }
}
