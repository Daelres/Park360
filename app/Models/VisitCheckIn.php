<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitCheckIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_order_id',
        'uploaded_qr_path',
        'visit_hour',
        'submitted_at',
    ];

    protected $casts = [
        'visit_hour' => 'string',
        'submitted_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TicketOrder::class, 'ticket_order_id');
    }
}
