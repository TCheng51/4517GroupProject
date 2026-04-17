<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $timeSlots = [
            ['label' => '2:00-4:00', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'sort_order' => 10],
            ['label' => '6:00-9:00', 'start_time' => '18:00:00', 'end_time' => '21:00:00', 'sort_order' => 20],
            ['label' => '9:00-11:00', 'start_time' => '21:00:00', 'end_time' => '23:00:00', 'sort_order' => 30],
        ];

        foreach ($timeSlots as $timeSlot) {
            TimeSlot::updateOrCreate(
                ['label' => $timeSlot['label']],
                $timeSlot + ['is_active' => true]
            );
        }
    }
}
