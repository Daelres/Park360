<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddonProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'stripe_product_id',
        'stripe_price_id',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(TicketOrderItem::class, 'item_id')
            ->where('item_type', 'addon');
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.');
    }
}
