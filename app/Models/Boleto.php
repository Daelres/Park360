<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boleto extends Model
{
    use HasFactory;

    protected $table = 'boleto';

    protected $fillable = [
        'orden_id',
        'tipo_ticket_id',
        'qr_code',
        'estado',
        'valido_desde',
        'valido_hasta',
    ];

    protected $casts = [
        'valido_desde' => 'date',
        'valido_hasta' => 'date',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function tipoTicket(): BelongsTo
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_ticket_id');
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class, 'boleto_id');
    }
}
