<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'recorded_at',
    ];

    protected $casts = [
        'value' => 'decimal:4',
        'recorded_at' => 'datetime',
    ];
}
