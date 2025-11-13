<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['slug' => 'manage_employees', 'name' => 'Gestionar empleados'],
            ['slug' => 'manage_attractions', 'name' => 'Gestionar atracciones'],
            ['slug' => 'record_incidents', 'name' => 'Registrar incidentes'],
            ['slug' => 'manage_tickets', 'name' => 'Gestionar boletos y ventas'],
            ['slug' => 'view_reports', 'name' => 'Ver reportes'],
            ['slug' => 'perform_check_in', 'name' => 'Realizar check-in'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['slug' => $permission['slug']], $permission);
        }

        $permissionsByRole = [
            'admin' => Permission::all()->pluck('id')->toArray(),
            'operator' => Permission::query()
                ->whereIn('slug', ['manage_attractions', 'record_incidents', 'manage_tickets', 'perform_check_in'])
                ->pluck('id')
                ->toArray(),
            'customer' => Permission::query()
                ->whereIn('slug', ['manage_tickets', 'perform_check_in'])
                ->pluck('id')
                ->toArray(),
        ];

        foreach ($permissionsByRole as $roleSlug => $permissionIds) {
            $role = Role::query()->where('slug', $roleSlug)->first();
            if ($role) {
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}
