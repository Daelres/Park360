<?php

namespace App\Models;

use App\Models\AddonProduct;
use App\Models\TicketOrder;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_order_id',
        'item_type',
        'item_id',
        'name',
        'quantity',
        'unit_amount',
        'is_primary',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_amount' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(TicketOrder::class, 'ticket_order_id');
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class, 'item_id')
            ->where('item_type', 'ticket');
    }

    public function addonProduct(): BelongsTo
    {
        return $this->belongsTo(AddonProduct::class, 'item_id')
            ->where('item_type', 'addon');
    }

    public function resolveItem(): TicketType|AddonProduct|null
    {
        return match ($this->item_type) {
            'ticket' => $this->relationLoaded('ticketType') ? $this->getRelation('ticketType') : $this->ticketType,
            'addon' => $this->relationLoaded('addonProduct') ? $this->getRelation('addonProduct') : $this->addonProduct,
            default => null,
        };
    }
}
