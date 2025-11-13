<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin General',
                'email' => 'admin@park360.test',
                'password' => Hash::make('password'),
                'roles' => ['admin'],
            ],
            [
                'name' => 'Operador Base',
                'email' => 'operador@park360.test',
                'password' => Hash::make('password'),
                'roles' => ['operator'],
            ],
            [
                'name' => 'Cliente Demo',
                'email' => 'cliente@park360.test',
                'password' => Hash::make('password'),
                'roles' => ['customer'],
            ],
        ];

        foreach ($users as $userData) {
            $roles = $userData['roles'];
            unset($userData['roles']);
            $user = User::query()->updateOrCreate(['email' => $userData['email']], $userData);
            $roleIds = Role::query()->whereIn('slug', $roles)->pluck('id');
            $user->roles()->sync($roleIds);
        }
    }
}
