<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reembolso extends Model
{
    use HasFactory;

    protected $table = 'reembolso';

    protected $fillable = [
        'pago_id',
        'monto',
        'motivo',
        'estado',
        'requested_at',
        'confirmed_at',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'requested_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}
