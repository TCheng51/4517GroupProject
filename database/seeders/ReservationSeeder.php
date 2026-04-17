<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::where('is_admin', false)->get();

        if ($members->isEmpty()) {
            $this->command->warn('No members found. Please run MemberSeeder first.');
            return;
        }

        $roomThemes = array_keys(config('rooms.themes'));
        $timeSlots = config('rooms.time_slots');

        // Mix past, today, and future so admin dashboard has variety.
        // Each row uses a distinct member/room/slot/date combo to respect the
        // new unique index on (member_id, reservation_date, time_slot, table_room).
        $plan = [
            ['offset' => 1,  'slot' => 0, 'room' => 0, 'status' => 'pending'],
            ['offset' => 2,  'slot' => 1, 'room' => 1, 'status' => 'confirmed'],
            ['offset' => 3,  'slot' => 2, 'room' => 2, 'status' => 'pending'],
            ['offset' => -1, 'slot' => 1, 'room' => 3, 'status' => 'confirmed'],
            ['offset' => -2, 'slot' => 0, 'room' => 4, 'status' => 'cancelled'],
            ['offset' => 5,  'slot' => 2, 'room' => 5, 'status' => 'pending'],
            ['offset' => 7,  'slot' => 1, 'room' => 0, 'status' => 'confirmed'],
            ['offset' => 0,  'slot' => 0, 'room' => 1, 'status' => 'pending'],
            ['offset' => 0,  'slot' => 1, 'room' => 2, 'status' => 'confirmed'],
            ['offset' => -3, 'slot' => 1, 'room' => 3, 'status' => 'confirmed'],
        ];

        DB::transaction(function () use ($plan, $members, $roomThemes, $timeSlots) {
            foreach ($plan as $i => $entry) {
                Reservation::create([
                    'member_id' => $members[$i % $members->count()]->id,
                    'reservation_date' => now()->addDays($entry['offset'])->format('Y-m-d'),
                    'time_slot' => $timeSlots[$entry['slot']],
                    'table_room' => $roomThemes[$entry['room']],
                    'status' => $entry['status'],
                ]);
            }
        });

        $this->command->info('Reservations seeded successfully! (' . count($plan) . ' rows)');
    }
}
