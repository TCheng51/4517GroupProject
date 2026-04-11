<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all members to associate reservations with
        $members = Member::all();
        
        if ($members->isEmpty()) {
            $this->command->warn('No members found. Please run MemberSeeder first.');
            return;
        }

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
    }
}
