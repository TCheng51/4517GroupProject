<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
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
                'password' => 'password123',
                'is_admin' => false,
            ],
            [
                'member_number' => '0002',
                'first_name' => 'Emma',
                'last_name' => 'Wong',
                'email' => 'emma.wong@example.com',
                'phone' => '85298765432',
                'address' => "Unit 5B, Tower Heights, 456 Queen's Road Central, Hong Kong",
                'password' => 'password123',
                'is_admin' => false,
            ],
            [
                'member_number' => '0003',
                'first_name' => 'Ryan',
                'last_name' => 'Lee',
                'email' => 'ryan.lee@example.com',
                'phone' => '85255512345',
                'address' => 'Room 803, Ocean View Mansion, 789 Conduit Road, Mid-Levels',
                'password' => 'password123',
                'is_admin' => false,
            ],
            [
                'member_number' => '0004',
                'first_name' => 'Sophie',
                'last_name' => 'Lam',
                'email' => 'sophie.lam@example.com',
                'phone' => '85244498765',
                'address' => 'Shop G, Garden Plaza, 321 Canton Road, Tsim Sha Tsui',
                'password' => 'password123',
                'is_admin' => false,
            ],
            [
                'member_number' => '0005',
                'first_name' => 'Kevin',
                'last_name' => 'Ho',
                'email' => 'kevin.ho@example.com',
                'phone' => '85277724681',
                'address' => 'Flat 15F, Sky Tower, 654 Hennessy Road, Wan Chai',
                'password' => 'password123',
                'is_admin' => false,
            ],
            // Test admin — email: admin@fable.test / password: admin1234
            [
                'member_number' => '9999',
                'first_name' => 'Fable',
                'last_name' => 'Admin',
                'email' => 'admin@fable.test',
                'phone' => '85200000000',
                'address' => 'Fable Tavern, Story Lane',
                'password' => 'admin1234',
                'is_admin' => true,
            ],
        ];

        DB::transaction(function () use ($members) {
            foreach ($members as $member) {
                // The Member model's 'hashed' cast hashes the password on insert.
                Member::updateOrCreate(
                    ['email' => $member['email']],
                    $member
                );
            }
        });

        $this->command->info('Members seeded successfully! (' . count($members) . ' total, 1 admin)');
    }
}
