<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoTicket extends Model
{
    use HasFactory;

    protected $table = 'tipo_ticket';

    protected $fillable = [
        'nombre',
        'validez_dias',
        'reingresos',
        'descripcion',
    ];

    protected $casts = [
        'reingresos' => 'boolean',
    ];

    public function tarifas(): HasMany
    {
        return $this->hasMany(Tarifa::class, 'tipo_ticket_id');
    }

    public function itemsOrden(): HasMany
    {
        return $this->hasMany(OrdenItem::class, 'tipo_ticket_id');
    }

    public function boletos(): HasMany
    {
        return $this->hasMany(Boleto::class, 'tipo_ticket_id');
    }
}
