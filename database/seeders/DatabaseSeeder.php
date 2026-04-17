<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed members for registration testing
        $this->call([
<<<<<<< HEAD
=======
            RoomSeeder::class,
            TimeSlotSeeder::class,
            MenuItemSeeder::class,
>>>>>>> cab9cfdee1c177ab35c534b66d3680996e16d5fb
            MemberSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
