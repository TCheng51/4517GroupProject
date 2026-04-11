<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            [
                'member_number' => '0001',
                'first_name' => 'Alex',
                'last_name' => 'Chan',
                'email' => 'alex.chan@example.com',
                'phone' => '85212345678',
                'address' => 'Flat 12A, Dragon Building, 123 Nathan Road, Mong Kok',
                'password' => Hash::make('password123'),
            ],
            [
                'member_number' => '0002',
                'first_name' => 'Emma',
                'last_name' => 'Wong',
                'email' => 'emma.wong@example.com',
                'phone' => '85298765432',
                'address' => 'Unit 5B, Tower Heights, 456 Queen\'s Road Central, Hong Kong',
                'password' => Hash::make('password123'),
            ],
            [
                'member_number' => '0003',
                'first_name' => 'Ryan',
                'last_name' => 'Lee',
                'email' => 'ryan.lee@example.com',
                'phone' => '85255512345',
                'address' => 'Room 803, Ocean View Mansion, 789 Conduit Road, Mid-Levels',
                'password' => Hash::make('password123'),
            ],
            [
                'member_number' => '0004',
                'first_name' => 'Sophie',
                'last_name' => 'Lam',
                'email' => 'sophie.lam@example.com',
                'phone' => '85244498765',
                'address' => 'Shop G, Garden Plaza, 321 Canton Road, Tsim Sha Tsui',
                'password' => Hash::make('password123'),
            ],
            [
                'member_number' => '0005',
                'first_name' => 'Kevin',
                'last_name' => 'Ho',
                'email' => 'kevin.ho@example.com',
                'phone' => '85277724681',
                'address' => 'Flat 15F, Sky Tower, 654 Hennessy Road, Wan Chai',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }

        $this->command->info('Members seeded successfully!');
        $this->command->info('Total members created: ' . count($members));
        
        // Display created members with their member numbers
        $createdMembers = Member::whereIn('email', array_column($members, 'email'))->get();
        $this->command->info("\n=== Created Members ===");
        foreach ($createdMembers as $member) {
            $this->command->line("{$member->member_number}: {$member->first_name} {$member->last_name} ({$member->email})");
        }
    }
}
