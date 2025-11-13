<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'base_price',
        'stripe_product_id',
        'stripe_price_id',
        'sede_id',
    ];

    protected $casts = [
        'sede_id' => 'integer',
        'base_price' => 'integer',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(TicketOrderItem::class, 'item_id')
            ->where('item_type', 'ticket');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->base_price, 0, ',', '.');
    }
}
