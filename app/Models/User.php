<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->roles->loadMissing('permissions')->pluck('permissions')->flatten()->unique('id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = Arr::wrap($roles);

        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->contains(fn ($perm) => $perm->slug === $permission);
    }

    public function setPasswordAttribute($value): void
    {
        if (! $value) {
            return;
        }

        $info = password_get_info($value);
        $this->attributes['password'] = $info['algo'] ? $value : Hash::make($value);
    }
}
