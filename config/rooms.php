<?php

return [
    /*
     * Available time slots for reservations. Presented to users in the reservation
     * form and used by showRoomStatus to compute availability per slot.
     */
    'time_slots' => ['2:00-4:00', '6:00-9:00', '9:00-11:00'],

    /*
     * Story-themed rooms available for booking. `capacity` is the maximum number
     * of simultaneous reservations per (date, time_slot) combination.
     */
    'themes' => [
        'fantasy-hearth' => [
            'name' => 'Fantasy Hearth',
            'capacity' => 4,
            'description' => 'A cozy medieval tavern setting with warm lighting, wooden tables, and fantasy decor perfect for RPG sessions.',
        ],
        'mythic-garden' => [
            'name' => 'Mythic Garden',
            'capacity' => 4,
            'description' => 'An enchanted forest atmosphere with lush greenery, natural elements, and mystical ambiance.',
        ],
        'iron-archive' => [
            'name' => 'Iron Archive',
            'capacity' => 4,
            'description' => 'A steampunk library setting with metal accents, gears, and Victorian-inspired decor.',
        ],
        'starlight-orbit' => [
            'name' => 'Starlight Orbit',
            'capacity' => 6,
            'description' => 'A futuristic space station theme with cosmic lighting and sci-fi elements.',
        ],
        'clockwork-vault' => [
            'name' => 'Clockwork Vault',
            'capacity' => 6,
            'description' => 'A mysterious mechanical chamber with intricate clockwork mechanisms and puzzle-solving atmosphere.',
        ],
        'storykeeper-suite' => [
            'name' => 'Storykeeper Suite',
            'capacity' => 8,
            'description' => 'A grand literary salon with bookshelves, comfortable seating, and storytelling ambiance.',
        ],
    ],
];
