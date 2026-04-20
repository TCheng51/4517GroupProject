<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\TimeSlot;
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

        $rooms = Room::active()->orderBy('sort_order')->get();
        $timeSlots = TimeSlot::active()->orderBy('sort_order')->get();

        if ($rooms->isEmpty() || $timeSlots->isEmpty()) {
            $this->command->warn('No rooms or time slots found. Please run RoomSeeder and TimeSlotSeeder first.');
            return;
        }

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

        DB::transaction(function () use ($plan, $members, $rooms, $timeSlots) {
            foreach ($plan as $i => $entry) {
                $member = $members[$i % $members->count()];
                $room = $rooms[$entry['room']];
                $timeSlot = $timeSlots[$entry['slot']];
                $date = now()->addDays($entry['offset'])->format('Y-m-d');

                $baseCode = 'FBSEED' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT);
                $confirmationCode = $this->makeUniqueConfirmationCode($baseCode);

                Reservation::updateOrCreate([
                    'member_id' => $member->id,
                    'reservation_date' => $date,
                    'room_id' => $room->id,
                    'time_slot_id' => $timeSlot->id,
                ], [
                    'time_slot' => $timeSlot->label,
                    'table_room' => $room->slug,
                    'status' => $entry['status'],
                    'confirmation_code' => $confirmationCode,
                    'confirmed_at' => $entry['status'] === 'confirmed' ? now() : null,
                    'cancelled_at' => $entry['status'] === 'cancelled' ? now() : null,
                ]);
            }
        });

        $this->command->info('Reservations seeded successfully! (' . count($plan) . ' rows)');
    }

    private function makeUniqueConfirmationCode(string $baseCode): string
    {
        $code = $baseCode;
        $suffix = 1;

        while (Reservation::where('confirmation_code', $code)->exists()) {
            $code = sprintf('%s-%d', $baseCode, $suffix++);
        }

        return $code;
    }
}
