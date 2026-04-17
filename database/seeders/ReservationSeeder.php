<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\Reservation;
use App\Models\Member;
=======
use App\Models\Member;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\TimeSlot;
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all members to associate reservations with
        $members = Member::all();
        
=======
    public function run(): void
    {
        $members = Member::where('is_admin', false)->get();

>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
        if ($members->isEmpty()) {
            $this->command->warn('No members found. Please run MemberSeeder first.');
            return;
        }

<<<<<<< HEAD
        // Sample reservation data matching the form room themes
        $roomThemes = [
            'fantasy-hearth',
            'mythic-garden', 
            'iron-archive',
            'starlight-orbit',
            'clockwork-vault',
            'storykeeper-suite'
        ];

        $timeSlots = [
            '2:00-4:00',
            '6:00-9:00', 
            '9:00-11:00'
        ];

        $reservations = [
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addDays(1)->format('Y-m-d'),
                'time_slot' => $timeSlots[0],
                'table_room' => $roomThemes[0],
                'status' => 'pending',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addDays(2)->format('Y-m-d'),
                'time_slot' => $timeSlots[1],
                'table_room' => $roomThemes[1],
                'status' => 'confirmed',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addDays(3)->format('Y-m-d'),
                'time_slot' => $timeSlots[2],
                'table_room' => $roomThemes[2],
                'status' => 'pending',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->subDays(1)->format('Y-m-d'),
                'time_slot' => $timeSlots[1],
                'table_room' => $roomThemes[3],
                'status' => 'confirmed',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->subDays(2)->format('Y-m-d'),
                'time_slot' => $timeSlots[0],
                'table_room' => $roomThemes[4],
                'status' => 'cancelled',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addDays(5)->format('Y-m-d'),
                'time_slot' => $timeSlots[2],
                'table_room' => $roomThemes[5],
                'status' => 'pending',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addWeek()->format('Y-m-d'),
                'time_slot' => $timeSlots[1],
                'table_room' => $roomThemes[0],
                'status' => 'confirmed',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->format('Y-m-d'),
                'time_slot' => $timeSlots[0],
                'table_room' => $roomThemes[1],
                'status' => 'pending',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->addDays(4)->format('Y-m-d'),
                'time_slot' => $timeSlots[2],
                'table_room' => $roomThemes[2],
                'status' => 'confirmed',
            ],
            [
                'member_id' => $members->random()->id,
                'reservation_date' => now()->subDays(3)->format('Y-m-d'),
                'time_slot' => $timeSlots[1],
                'table_room' => $roomThemes[3],
                'status' => 'confirmed',
            ],
        ];

        // Insert reservations
        foreach ($reservations as $reservationData) {
            Reservation::create($reservationData);
        }

        $this->command->info('Reservations seeded successfully!');
        $this->command->info('Total reservations created: ' . count($reservations));
        
        // Display statistics
        $this->displayReservationStats();
    }

    /**
     * Display reservation statistics
     */
    private function displayReservationStats(): void
    {
        $stats = [
            'Total Reservations' => Reservation::count(),
            'Pending' => Reservation::where('status', 'pending')->count(),
            'Confirmed' => Reservation::where('status', 'confirmed')->count(),
            'Cancelled' => Reservation::where('status', 'cancelled')->count(),
            'Today' => Reservation::whereDate('reservation_date', today())->count(),
            'This Week' => Reservation::whereBetween('reservation_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        $this->command->info("\n=== Reservation Statistics ===");
        foreach ($stats as $label => $count) {
            $this->command->line("{$label}: {$count}");
        }
=======
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

                Reservation::updateOrCreate([
                    'member_id' => $member->id,
                    'reservation_date' => $date,
                    'room_id' => $room->id,
                    'time_slot_id' => $timeSlot->id,
                ], [
                    'time_slot' => $timeSlot->label,
                    'table_room' => $room->slug,
                    'status' => $entry['status'],
                    'confirmation_code' => 'FBSEED' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'confirmed_at' => $entry['status'] === 'confirmed' ? now() : null,
                    'cancelled_at' => $entry['status'] === 'cancelled' ? now() : null,
                ]);
            }
        });

        $this->command->info('Reservations seeded successfully! (' . count($plan) . ' rows)');
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
    }
}
