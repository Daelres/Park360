<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TicketOrder;

class VisitDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_date',
        'is_active',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(TicketOrder::class);
    }
}
