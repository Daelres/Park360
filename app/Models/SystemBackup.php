<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemBackup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'path',
        'type',
        'size',
        'created_at',
        'verified_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
}
