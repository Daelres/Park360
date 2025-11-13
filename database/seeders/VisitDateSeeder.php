<?php

namespace Database\Seeders;

use App\Models\VisitDate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VisitDateSeeder extends Seeder
{
    /**
     * Seed the visit_dates table with the next 60 days.
     */
    public function run(): void
    {
        $start = Carbon::now('UTC')->startOfDay();

        for ($i = 0; $i < 60; $i++) {
            VisitDate::updateOrCreate(
                ['visit_date' => $start->copy()->addDays($i)->toDateString()],
                ['is_active' => true]
            );
        }
    }
}
