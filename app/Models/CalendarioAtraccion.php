<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarioAtraccion extends Model
{
    use HasFactory;

    protected $table = 'calendario_atraccion';

    protected $fillable = [
        'atraccion_id',
        'inicio',
        'fin',
        'tipo',
    ];

    protected $casts = [
        'inicio' => 'date',
        'fin' => 'date',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atraccion_id');
    }
}
