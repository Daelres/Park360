<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'ciudad',
        'direccion',
        'telefono',
        'correo_contacto',
        'descripcion',
        'gerente',
    ];

    public function atracciones(): HasMany
    {
        return $this->hasMany(Atraccion::class, 'sede_id');
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }
}
