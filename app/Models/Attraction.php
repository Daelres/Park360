<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'capacity',
        'location',
        'opening_time',
        'closing_time',
        'last_inspection_at',
        'next_maintenance_at',
        'safety_score',
        'maintenance_notes',
    ];

    protected $casts = [
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'last_inspection_at' => 'datetime',
        'next_maintenance_at' => 'datetime',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withTimestamps()->withPivot('assigned_at');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function metrics()
    {
        return $this->hasMany(AttractionMetric::class);
    }
}
