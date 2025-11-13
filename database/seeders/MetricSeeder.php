<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\AttractionMetric;
use App\Models\SystemMetric;
use Illuminate\Database\Seeder;

class MetricSeeder extends Seeder
{
    public function run(): void
    {
        $date = now()->subDay()->toDateString();

        foreach (Attraction::query()->get() as $attraction) {
            AttractionMetric::query()->updateOrCreate(
                [
                    'attraction_id' => $attraction->id,
                    'date' => $date,
                ],
                [
                    'visitors_count' => rand(150, 800),
                    'incidents_count' => rand(0, 2),
                    'maintenance_count' => rand(0, 1),
                    'satisfaction_score' => rand(75, 100) / 10,
                ]
            );
        }

        $metrics = [
            ['name' => 'daily_sales', 'value' => 450000.00],
            ['name' => 'daily_visitors', 'value' => 350.0],
            ['name' => 'incident_response_time', 'value' => 12.5],
        ];

        foreach ($metrics as $metric) {
            SystemMetric::query()->updateOrCreate(
                [
                    'name' => $metric['name'],
                    'recorded_at' => now()->startOfDay(),
                ],
                ['value' => $metric['value']]
            );
        }
    }
}
