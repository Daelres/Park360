<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'attraction_id',
        'title',
        'description',
        'frequency',
        'status',
        'scheduled_for',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function assignments()
    {
        return $this->belongsToMany(Employee::class, 'task_assignments')->withTimestamps()->withPivot('assigned_by', 'assigned_at');
    }
}
