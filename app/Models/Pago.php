<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';

    protected $fillable = [
        'orden_id',
        'proveedor',
        'monto',
        'moneda',
        'estado',
        'aut_code',
        'trans_id_ext',
        'paid_at',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function reembolsos(): HasMany
    {
        return $this->hasMany(Reembolso::class, 'pago_id');
    }

    public function eventosPayu(): HasMany
    {
        return $this->hasMany(PayuEvent::class, 'pago_id');
    }
}
