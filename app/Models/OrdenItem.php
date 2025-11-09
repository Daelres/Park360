<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenItem extends Model
{
    use HasFactory;

    protected $table = 'orden_item';

    protected $fillable = [
        'orden_id',
        'tipo_ticket_id',
        'cantidad',
        'precio_unitario',
        'impuestos',
        'descuento',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'descuento' => 'decimal:2',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function tipoTicket(): BelongsTo
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_ticket_id');
    }
}
