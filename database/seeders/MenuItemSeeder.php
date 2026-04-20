<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['category' => 'Beverages', 'name' => "Dragon's Breath Espresso", 'description' => 'Bold double espresso with a hint of cinnamon and dragon fruit syrup', 'price' => 28, 'tags' => ['Strong', 'Spicy'], 'sort_order' => 10],
            ['category' => 'Beverages', 'name' => 'Elven Forest Latte', 'description' => 'Smooth latte with matcha, honey, and a touch of lavender', 'price' => 35, 'tags' => ['Floral', 'Sweet'], 'sort_order' => 20],
            ['category' => 'Beverages', 'name' => "Dwarf's Mocha Hammer", 'description' => 'Rich mocha with dark chocolate, caramel, and espresso', 'price' => 32, 'tags' => ['Chocolate', 'Strong'], 'sort_order' => 30],
            ['category' => 'Beverages', 'name' => "Wizard's Wisdom Tea", 'description' => 'Earl grey with bergamot, star anise, and wisdom-enhancing herbs', 'price' => 23, 'tags' => ['Herbal', 'Aromatic'], 'sort_order' => 40],
            ['category' => 'Beverages', 'name' => 'Phoenix Rising Cappuccino', 'description' => 'Classic cappuccino with orange zest and a fiery chili kick', 'price' => 30, 'tags' => ['Citrus', 'Spicy'], 'sort_order' => 50],
            ['category' => 'Beverages', 'name' => "Mermaid's Iced Tea", 'description' => 'Blue pea flower tea with lemon, mint, and a shimmer of magic', 'price' => 25, 'tags' => ['Refreshing', 'Colorful'], 'sort_order' => 60],
            ['category' => 'Snacks', 'name' => 'Dice Roll Pretzels', 'description' => 'Salted pretzels shaped like d20s with cheese dip', 'price' => 18, 'tags' => ['Savory', 'Crunchy'], 'sort_order' => 110],
            ['category' => 'Snacks', 'name' => 'Health Potion Fruit Cup', 'description' => 'Mixed berries with dragon fruit and passion fruit dressing', 'price' => 20, 'tags' => ['Healthy', 'Sweet'], 'sort_order' => 120],
            ['category' => 'Snacks', 'name' => 'Critical Hit Cookies', 'description' => 'Chocolate chip cookies with 20-sided chocolate pieces', 'price' => 23, 'tags' => ['Sweet', 'Chocolate'], 'sort_order' => 130],
            ['category' => 'Snacks', 'name' => 'Mana Trail Mix', 'description' => 'Mixed nuts, dried fruits, and chocolate gems', 'price' => 28, 'tags' => ['Energy', 'Mixed'], 'sort_order' => 140],
            ['category' => 'Meals', 'name' => "Paladin's Panini", 'description' => 'Grilled chicken with pesto, mozzarella, and roasted vegetables', 'price' => 50, 'tags' => ['Grilled', 'Filling'], 'sort_order' => 210],
            ['category' => 'Meals', 'name' => "Ranger's Forest Wrap", 'description' => 'Whole wheat wrap with turkey, avocado, and fresh greens', 'price' => 45, 'tags' => ['Healthy', 'Fresh'], 'sort_order' => 220],
            ['category' => 'Meals', 'name' => "Bard's Burger", 'description' => 'Beef patty with caramelized onions, bacon, and special sauce', 'price' => 58, 'tags' => ['Classic', 'Hearty'], 'sort_order' => 230],
            ['category' => 'Meals', 'name' => "Mage's Veggie Bowl", 'description' => 'Quinoa bowl with roasted vegetables, chickpeas, and tahini', 'price' => 42, 'tags' => ['Vegetarian', 'Nutritious'], 'sort_order' => 240],
            ['category' => 'Desserts', 'name' => 'Treasure Chest Brownie', 'description' => 'Fudgy brownie with gold chocolate coins and hidden gems', 'price' => 32, 'tags' => ['Chocolate', 'Decadent'], 'sort_order' => 310],
            ['category' => 'Desserts', 'name' => 'Enchanted Forest Cake', 'description' => 'Chocolate cake with mushroom meringues and moss-green frosting', 'price' => 38, 'tags' => ['Chocolate', 'Artistic'], 'sort_order' => 320],
            ['category' => 'Desserts', 'name' => 'Crystal Cupcake', 'description' => 'Vanilla cupcake with crystallized sugar and edible glitter', 'price' => 20, 'tags' => ['Sweet', 'Sparkling'], 'sort_order' => 330],
            ['category' => 'Games', 'name' => 'Catan: Cities & Knights', 'description' => 'Expansion to the classic Catan with city development and knight mechanics for 3-4 players.', 'price' => 0, 'tags' => ['Strategy', '3-4 Players'], 'sort_order' => 410],
            ['category' => 'Games', 'name' => 'Wingspan', 'description' => 'Bird-themed engine building game where players collect birds, food, and eggs to build a preserve.', 'price' => 0, 'tags' => ['Engine Building', '1-5 Players'], 'sort_order' => 420],
            ['category' => 'Games', 'name' => 'Gloomhaven', 'description' => 'Epic tactical combat campaign game with monsters, levels, and a massive legacy world.', 'price' => 0, 'tags' => ['Campaign', '1-4 Players'], 'sort_order' => 430],
            ['category' => 'Games', 'name' => 'Azul', 'description' => 'Tile-laying mosaic game that is easy to learn and challenging to master for 2-4 players.', 'price' => 0, 'tags' => ['Abstract', '2-4 Players'], 'sort_order' => 440],
            ['category' => 'Games', 'name' => 'Pandemic Legacy: Season 1', 'description' => 'Cooperative campaign where decisions permanently change the game and save humanity.', 'price' => 0, 'tags' => ['Cooperative', '2-4 Players'], 'sort_order' => 450],
            ['category' => 'Games', 'name' => 'Terraforming Mars', 'description' => 'Resource management game where players compete to make Mars habitable.', 'price' => 0, 'tags' => ['Economic', '1-5 Players'], 'sort_order' => 460],
        ];

        foreach ($items as $item) {
            MenuItem::updateOrCreate(
                ['name' => $item['name']],
                $item + ['is_active' => true]
            );
        }
    }
}
