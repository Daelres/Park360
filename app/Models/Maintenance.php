<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attraction_id',
        'requested_by_employee_id',
        'performed_by_employee_id',
        'status',
        'scheduled_for',
        'started_at',
        'completed_at',
        'cost',
        'description',
        'findings',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function attraction()
    {
        return $this->belongsTo(Attraction::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(Employee::class, 'requested_by_employee_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(Employee::class, 'performed_by_employee_id');
    }
}
