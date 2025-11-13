<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            AttractionSeeder::class,
            TaskSeeder::class,
            TicketTypeSeeder::class,
            OrderSeeder::class,
            MetricSeeder::class,
        ]);
    }
}
