<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreferenciaNotificacion extends Model
{
    use HasFactory;

    protected $table = 'preferencia_notificacion';

    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'canal_email',
        'horario_silencio',
    ];

    protected $casts = [
        'canal_email' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
