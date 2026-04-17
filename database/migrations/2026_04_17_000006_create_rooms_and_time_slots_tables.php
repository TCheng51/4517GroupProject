<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->unsignedInteger('capacity');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        $rooms = [
            ['slug' => 'fantasy-hearth', 'name' => 'Fantasy Hearth', 'capacity' => 4, 'description' => 'A cozy medieval tavern setting with warm lighting, wooden tables, and fantasy decor perfect for RPG sessions.', 'sort_order' => 10],
            ['slug' => 'mythic-garden', 'name' => 'Mythic Garden', 'capacity' => 4, 'description' => 'An enchanted forest atmosphere with lush greenery, natural elements, and mystical ambiance.', 'sort_order' => 20],
            ['slug' => 'iron-archive', 'name' => 'Iron Archive', 'capacity' => 4, 'description' => 'A steampunk library setting with metal accents, gears, and Victorian-inspired decor.', 'sort_order' => 30],
            ['slug' => 'starlight-orbit', 'name' => 'Starlight Orbit', 'capacity' => 6, 'description' => 'A futuristic space station theme with cosmic lighting and sci-fi elements.', 'sort_order' => 40],
            ['slug' => 'clockwork-vault', 'name' => 'Clockwork Vault', 'capacity' => 6, 'description' => 'A mysterious mechanical chamber with intricate clockwork mechanisms and puzzle-solving atmosphere.', 'sort_order' => 50],
            ['slug' => 'storykeeper-suite', 'name' => 'Storykeeper Suite', 'capacity' => 8, 'description' => 'A grand literary salon with bookshelves, comfortable seating, and storytelling ambiance.', 'sort_order' => 60],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert($room + [
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $timeSlots = [
            ['label' => '2:00-4:00', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'sort_order' => 10],
            ['label' => '6:00-9:00', 'start_time' => '18:00:00', 'end_time' => '21:00:00', 'sort_order' => 20],
            ['label' => '9:00-11:00', 'start_time' => '21:00:00', 'end_time' => '23:00:00', 'sort_order' => 30],
        ];

        foreach ($timeSlots as $timeSlot) {
            DB::table('time_slots')->insert($timeSlot + [
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
        Schema::dropIfExists('rooms');
    }
};
