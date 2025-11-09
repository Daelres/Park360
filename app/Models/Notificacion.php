<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';

    protected $fillable = [
        'tipo',
        'origen',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function destinos(): HasMany
    {
        return $this->hasMany(NotificacionDestino::class, 'notificacion_id');
    }
}
