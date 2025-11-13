<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'scanned_by',
        'scanned_at',
        'location',
        'device',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
