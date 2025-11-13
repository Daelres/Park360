<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttractionMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'attraction_id',
        'date',
        'visitors_count',
        'incidents_count',
        'maintenance_count',
        'satisfaction_score',
    ];

    protected $casts = [
        'date' => 'date',
        'satisfaction_score' => 'decimal:2',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }
}
