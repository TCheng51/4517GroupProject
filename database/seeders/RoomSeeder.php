<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['slug' => 'fantasy-hearth', 'name' => 'Fantasy Hearth', 'capacity' => 4, 'description' => 'A cozy medieval tavern setting with warm lighting, wooden tables, and fantasy decor perfect for RPG sessions.', 'sort_order' => 10],
            ['slug' => 'mythic-garden', 'name' => 'Mythic Garden', 'capacity' => 4, 'description' => 'An enchanted forest atmosphere with lush greenery, natural elements, and mystical ambiance.', 'sort_order' => 20],
            ['slug' => 'iron-archive', 'name' => 'Iron Archive', 'capacity' => 4, 'description' => 'A steampunk library setting with metal accents, gears, and Victorian-inspired decor.', 'sort_order' => 30],
            ['slug' => 'starlight-orbit', 'name' => 'Starlight Orbit', 'capacity' => 6, 'description' => 'A futuristic space station theme with cosmic lighting and sci-fi elements.', 'sort_order' => 40],
            ['slug' => 'clockwork-vault', 'name' => 'Clockwork Vault', 'capacity' => 6, 'description' => 'A mysterious mechanical chamber with intricate clockwork mechanisms and puzzle-solving atmosphere.', 'sort_order' => 50],
            ['slug' => 'storykeeper-suite', 'name' => 'Storykeeper Suite', 'capacity' => 8, 'description' => 'A grand literary salon with bookshelves, comfortable seating, and storytelling ambiance.', 'sort_order' => 60],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['slug' => $room['slug']],
                $room + ['is_active' => true]
            );
        }
    }
}
