<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'attraction_id',
        'reported_by_employee_id',
        'title',
        'description',
        'severity',
        'status',
        'reported_at',
        'resolved_at',
        'resolution_notes',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(Employee::class, 'reported_by_employee_id');
    }
}
