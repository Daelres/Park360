<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $operatorRole = Role::query()->where('slug', 'operator')->first();
        $users = User::query()->pluck('id', 'email');

        $employees = [
            [
                'first_name' => 'Laura',
                'last_name' => 'Gómez',
                'email' => 'laura.gomez@park360.test',
                'phone' => '+57 300 000 0001',
                'position' => 'Supervisora de Atracciones',
                'document_number' => '10203040',
                'hire_date' => '2022-01-10',
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Pérez',
                'email' => 'carlos.perez@park360.test',
                'phone' => '+57 300 000 0002',
                'position' => 'Operador Senior',
                'document_number' => '40506070',
                'hire_date' => '2021-08-05',
            ],
            [
                'first_name' => 'Diana',
                'last_name' => 'Torres',
                'email' => 'diana.torres@park360.test',
                'phone' => '+57 300 000 0003',
                'position' => 'Técnica de mantenimiento',
                'document_number' => '50607080',
                'hire_date' => '2020-03-20',
            ],
            [
                'first_name' => 'Miguel',
                'last_name' => 'Ruiz',
                'email' => 'miguel.ruiz@park360.test',
                'phone' => '+57 300 000 0004',
                'position' => 'Operador Junior',
                'document_number' => '60708090',
                'hire_date' => '2023-02-12',
            ],
            [
                'first_name' => 'Paula',
                'last_name' => 'Castro',
                'email' => 'paula.castro@park360.test',
                'phone' => '+57 300 000 0005',
                'position' => 'Coordinadora de seguridad',
                'document_number' => '70809010',
                'hire_date' => '2019-11-01',
            ],
        ];

        foreach ($employees as $employeeData) {
            $userId = $users[$employeeData['email']] ?? null;
            $employee = Employee::query()->updateOrCreate(
                ['email' => $employeeData['email']],
                [
                    'user_id' => $userId,
                    'first_name' => $employeeData['first_name'],
                    'last_name' => $employeeData['last_name'],
                    'email' => $employeeData['email'],
                    'phone' => $employeeData['phone'],
                    'position' => $employeeData['position'],
                    'document_number_encrypted' => Crypt::encryptString($employeeData['document_number']),
                    'hire_date' => $employeeData['hire_date'],
                    'status' => 'active',
                ]
            );

            if ($userId && $operatorRole) {
                User::query()->find($userId)?->roles()->syncWithoutDetaching([$operatorRole->id]);
            }

            $employee->attendance()->updateOrCreate(
                ['date' => now()->toDateString()],
                [
                    'status' => 'present',
                    'checked_in_at' => now(),
                ]
            );
        }
    }
}
