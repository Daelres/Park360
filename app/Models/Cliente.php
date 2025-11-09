<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $fillable = [
        'email',
        'nombre',
        'telefono',
        'pais',
    ];

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class, 'cliente_id');
    }

    public function preferenciasNotificacion(): HasMany
    {
        return $this->hasMany(PreferenciaNotificacion::class, 'cliente_id');
    }
}
