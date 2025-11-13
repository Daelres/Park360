<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@park360.test'],
            [
                'name' => 'Administración Park360',
                'password' => 'password',
            ]
        );
    }
}
