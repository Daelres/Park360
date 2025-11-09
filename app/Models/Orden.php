<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'orden';

    protected $fillable = [
        'cliente_id',
        'numero_orden',
        'estado',
        'total',
        'canal',
        'ip_cliente',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrdenItem::class, 'orden_id');
    }

    public function boletos(): HasMany
    {
        return $this->hasMany(Boleto::class, 'orden_id');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'orden_id');
    }

    public function eventosPayu(): HasMany
    {
        return $this->hasMany(PayuEvent::class, 'orden_id');
    }
}
