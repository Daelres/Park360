<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{
    use HasFactory;

    protected $appends = ['full_name'];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'document_number_encrypted',
        'hire_date',
        'termination_date',
        'status',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'termination_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attractions()
    {
        return $this->belongsToMany(Attraction::class)->withTimestamps()->withPivot('assigned_at');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_assignments')->withTimestamps();
    }

    public function attendance()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }

    protected function documentNumber(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->document_number_encrypted) {
                    return null;
                }

                try {
                    return Crypt::decryptString($this->document_number_encrypted);
                } catch (\Throwable $exception) {
                    return null;
                }
            },
            set: fn ($value) => [
                'document_number_encrypted' => $value
                    ? Crypt::encryptString($value)
                    : null,
            ]
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->first_name . ' ' . $this->last_name)
        );
    }
}
