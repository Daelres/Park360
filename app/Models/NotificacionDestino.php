<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificacionDestino extends Model
{
    use HasFactory;

    protected $table = 'notificacion_destino';

    protected $fillable = [
        'notificacion_id',
        'destinatario_email',
        'estado_envio',
        'proveedor_msg_id',
        'sent_at',
        'retry_count',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'retry_count' => 'integer',
    ];

    public function notificacion(): BelongsTo
    {
        return $this->belongsTo(Notificacion::class, 'notificacion_id');
    }
}
