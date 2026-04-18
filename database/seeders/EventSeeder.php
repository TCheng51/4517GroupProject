<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::pluck('id', 'slug');
        $now   = now();

        $events = [
            [
                'slug'             => 'roll-for-initiative-may',
                'title'            => 'Roll for Initiative — D&D Night',
                'description'      => 'Join fellow adventurers for a one-shot Dungeons & Dragons campaign led by an experienced Dungeon Master. All experience levels welcome — pre-made characters available for newcomers, or bring your own level-5 hero. The Fantasy Hearth will be dressed in full tavern mode with ambient sound, candlelight, and themed refreshments included.',
                'event_type'       => 'dnd_night',
                'event_date'       => now()->addDays(10)->toDateString(),
                'start_time'       => '18:00:00',
                'end_time'         => '22:00:00',
                'room_id'          => $rooms['fantasy-hearth'] ?? null,
                'max_participants' => 8,
                'entry_fee'        => 80.00,
                'is_featured'      => true,
                'sort_order'       => 10,
            ],
            [
                'slug'             => 'fable-grand-tournament-may',
                'title'            => 'The Fable Grand Tournament',
                'description'      => 'Fable\'s monthly competitive board game tournament returns. This month\'s featured title will be announced one week before the event. Players compete in Swiss-format rounds across the afternoon, with the top four advancing to a dramatic final in the Storykeeper Suite. Prizes include Fable store credit, exclusive member badges, and the coveted Champion\'s Goblet for the month.',
                'event_type'       => 'tournament',
                'event_date'       => now()->addDays(14)->toDateString(),
                'start_time'       => '14:00:00',
                'end_time'         => '21:00:00',
                'room_id'          => $rooms['storykeeper-suite'] ?? null,
                'max_participants' => 16,
                'entry_fee'        => 120.00,
                'is_featured'      => true,
                'sort_order'       => 20,
            ],
            [
                'slug'             => 'beginners-quest-may',
                'title'            => 'Beginner\'s Quest — Learn to Play Night',
                'description'      => 'New to board games or tabletop RPGs? This guided evening walks first-timers through three approachable modern classics — from cooperative storytelling to lightweight strategy. Staff game guides run each table, explain rules as you go, and help you discover which genres suit your group. Drinks and snacks are included in the entry fee.',
                'event_type'       => 'workshop',
                'event_date'       => now()->addDays(7)->toDateString(),
                'start_time'       => '18:30:00',
                'end_time'         => '21:00:00',
                'room_id'          => $rooms['mythic-garden'] ?? null,
                'max_participants' => 12,
                'entry_fee'        => 50.00,
                'is_featured'      => false,
                'sort_order'       => 30,
            ],
            [
                'slug'             => 'strategy-siege-may',
                'title'            => 'Strategy Siege — Euro Game Showdown',
                'description'      => 'An evening dedicated to heavy euro-style strategy games. Bring your own copy of Terraforming Mars, Brass: Birmingham, or Ark Nova — or borrow from the Fable library. Tables are grouped by title so you can find opponents matched to the game you want to play. The Iron Archive\'s focused atmosphere is ideal for deep, thoughtful sessions.',
                'event_type'       => 'game_night',
                'event_date'       => now()->addDays(21)->toDateString(),
                'start_time'       => '17:00:00',
                'end_time'         => '22:00:00',
                'room_id'          => $rooms['iron-archive'] ?? null,
                'max_participants' => 20,
                'entry_fee'        => 0.00,
                'is_featured'      => false,
                'sort_order'       => 40,
            ],
            [
                'slug'             => 'paint-and-play-may',
                'title'            => 'Paint & Play — Miniature Workshop',
                'description'      => 'Learn miniature painting basics from a local artist while enjoying Fable\'s cafe menu. All materials are provided: unpainted miniatures, brushes, paints, and a finishing coat. You take your painted figure home at the end of the night. Perfect for fans of Gloomhaven, Descent, or anyone curious about the hobby side of tabletop gaming.',
                'event_type'       => 'workshop',
                'event_date'       => now()->addDays(18)->toDateString(),
                'start_time'       => '15:00:00',
                'end_time'         => '18:00:00',
                'room_id'          => $rooms['clockwork-vault'] ?? null,
                'max_participants' => 10,
                'entry_fee'        => 150.00,
                'is_featured'      => false,
                'sort_order'       => 50,
            ],
            [
                'slug'             => 'mystery-at-fable-may',
                'title'            => 'Mystery at Fable — Murder Mystery Evening',
                'description'      => 'An immersive murder mystery dinner event set inside the Storykeeper Suite. Guests receive character cards on arrival, dress the part (costumes encouraged but optional), and work together to solve a scripted mystery over three acts and a full cafe dinner. The evening includes a welcome drink, a three-course themed meal, and a dramatic reveal at the finale.',
                'event_type'       => 'special',
                'event_date'       => now()->addDays(28)->toDateString(),
                'start_time'       => '19:00:00',
                'end_time'         => '23:00:00',
                'room_id'          => $rooms['storykeeper-suite'] ?? null,
                'max_participants' => 8,
                'entry_fee'        => 280.00,
                'is_featured'      => true,
                'sort_order'       => 60,
            ],
            [
                'slug'             => 'starlight-sci-fi-marathon',
                'title'            => 'Starlight Sci-Fi Marathon',
                'description'      => 'A full-day sci-fi board game marathon in the Starlight Orbit room. Play through iconic titles like Twilight Imperium, Eclipse, and Star Wars: Rebellion with rotating opponents. Lunch and snack breaks are built into the schedule. This is Fable\'s longest-running event and always fills up fast.',
                'event_type'       => 'game_night',
                'event_date'       => now()->addDays(35)->toDateString(),
                'start_time'       => '11:00:00',
                'end_time'         => '22:00:00',
                'room_id'          => $rooms['starlight-orbit'] ?? null,
                'max_participants' => 12,
                'entry_fee'        => 100.00,
                'is_featured'      => false,
                'sort_order'       => 70,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event + [
                'is_active'  => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
