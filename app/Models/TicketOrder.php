<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TicketOrder extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'visit_date_id',
        'uuid',
        'status',
        'stripe_session_id',
        'stripe_client_secret',
        'stripe_payment_intent_id',
        'total_amount',
        'paid_at',
        'failed_at',
        'qr_code_path',
        'qr_code_token',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (TicketOrder $order) {
            if (blank($order->uuid)) {
                $order->uuid = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visitDate(): BelongsTo
    {
        return $this->belongsTo(VisitDate::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TicketOrderItem::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(VisitCheckIn::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function calculateTotal(): int
    {
        return $this->items->sum(fn (TicketOrderItem $item) => $item->quantity * $item->unit_amount);
    }

    public function syncTotal(): void
    {
        $this->total_amount = $this->calculateTotal();
        $this->save();
    }

    public function itemSummary(): Collection
    {
        return $this->items->map(fn (TicketOrderItem $item) => [
            'name' => $item->name,
            'quantity' => $item->quantity,
            'unit_amount' => $item->unit_amount,
            'total' => $item->quantity * $item->unit_amount,
        ]);
    }
}
