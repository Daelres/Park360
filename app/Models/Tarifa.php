<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarifa extends Model
{
    use HasFactory;

    protected $table = 'tarifa';

    protected $fillable = [
        'tipo_ticket_id',
        'precio',
        'moneda',
        'vigncia_desde',
        'vigncia_hasta',
        'canal_venta',
        'regla',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'vigncia_desde' => 'date',
        'vigncia_hasta' => 'date',
        'regla' => 'array',
    ];

    public function tipoTicket(): BelongsTo
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_ticket_id');
    }
}
