<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'code',
        'qr_path',
        'status',
        'valid_from',
        'valid_until',
        'checked_in_at',
        'pdf_path',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'checked_in_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function scans()
    {
        return $this->hasMany(TicketScan::class);
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'valid')->where('valid_until', '>=', now());
    }
}
