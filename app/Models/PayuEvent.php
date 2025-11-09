<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayuEvent extends Model
{
    use HasFactory;

    protected $table = 'payu_event';

    protected $fillable = [
        'orden_id',
        'pago_id',
        'payload',
        'event_type',
        'received_at',
        'firma_valida',
        'replay_id',
    ];

    protected $casts = [
        'payload' => 'array',
        'received_at' => 'datetime',
        'firma_valida' => 'boolean',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}
