<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    use HasFactory;

    protected $table = 'zona';

    protected $fillable = [
        'nombre',
        'ubicacion',
    ];

    public function atracciones(): HasMany
    {
        return $this->hasMany(Atraccion::class, 'zona_id');
    }
}
