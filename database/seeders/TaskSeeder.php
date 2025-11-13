<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = Attraction::query()->get();
        $employees = Employee::query()->pluck('id')->toArray();

        foreach ($attractions as $attraction) {
            $tasks = [
                [
                    'title' => 'Inspección diaria',
                    'frequency' => 'daily',
                    'status' => 'completed',
                ],
                [
                    'title' => 'Limpieza general',
                    'frequency' => 'daily',
                    'status' => 'pending',
                ],
                [
                    'title' => 'Prueba de seguridad',
                    'frequency' => 'weekly',
                    'status' => 'in_progress',
                ],
            ];

            foreach ($tasks as $taskData) {
                $task = $attraction->tasks()->updateOrCreate(
                    ['title' => $taskData['title']],
                    [
                        'description' => 'Tarea automatizada para ' . Str::lower($taskData['title']),
                        'frequency' => $taskData['frequency'],
                        'status' => $taskData['status'],
                        'scheduled_for' => now()->addDays(rand(1, 5)),
                    ]
                );

                if ($employees) {
                    $task->assignments()->sync(array_slice($employees, 0, min(2, count($employees))));
                }
            }
        }
    }
}
