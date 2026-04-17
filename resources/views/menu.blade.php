@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Coffee Shop</p>
        <h2 class="section-title">Fabel Coffee Shop Menu</h2>
        <p class="page-intro">Fuel your gaming sessions with our carefully curated selection of beverages, snacks, and meals inspired by fantasy realms and adventures.</p>
    </section>

    <div class="panel">
        {{-- Beverages --}}
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="coffee"></i>
                </div>
                <p class="story-meta">Beverages</p>
                <h3>Coffee &amp; Potions</h3>
                <p>Artisanal brews and magical potions to energize your quests</p>
            </div>

            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="flame"></i></div>
                    <h3>Dragon's Breath Espresso</h3>
                    <p>Bold double espresso with a hint of cinnamon and dragon fruit syrup</p>
                    <p class="story-meta">HK$ 28 • Strong • Spicy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="leaf"></i></div>
                    <h3>Elven Forest Latte</h3>
                    <p>Smooth latte with matcha, honey, and a touch of lavender</p>
                    <p class="story-meta">HK$ 35 • Floral • Sweet</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="hammer"></i></div>
                    <h3>Dwarf's Mocha Hammer</h3>
                    <p>Rich mocha with dark chocolate, caramel, and espresso</p>
                    <p class="story-meta">HK$ 32 • Chocolate • Strong</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="wand-sparkles"></i></div>
                    <h3>Wizard's Wisdom Tea</h3>
                    <p>Earl grey with bergamot, star anise, and wisdom-enhancing herbs</p>
                    <p class="story-meta">HK$ 23 • Herbal • Aromatic</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="bird"></i></div>
                    <h3>Phoenix Rising Cappuccino</h3>
                    <p>Classic cappuccino with orange zest and a fiery chili kick</p>
                    <p class="story-meta">HK$ 30 • Citrus • Spicy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="droplets"></i></div>
                    <h3>Mermaid's Iced Tea</h3>
                    <p>Blue pea flower tea with lemon, mint, and a shimmer of magic</p>
                    <p class="story-meta">HK$ 25 • Refreshing • Colorful</p>
                </article>
            </div>
        </section>

        {{-- Snacks --}}
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="dices"></i>
                </div>
                <p class="story-meta">Snacks</p>
                <h3>Gaming Fuel</h3>
                <p>Quick bites that won't slow down your gameplay</p>
            </div>

            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="cookie"></i></div>
                    <h3>Dice Roll Pretzels</h3>
                    <p>Salted pretzels shaped like d20s with cheese dip</p>
                    <p class="story-meta">HK$ 18 • Savory • Crunchy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="cherry"></i></div>
                    <h3>Health Potion Fruit Cup</h3>
                    <p>Mixed berries with dragon fruit and passion fruit dressing</p>
                    <p class="story-meta">HK$ 20 • Healthy • Sweet</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="candy"></i></div>
                    <h3>Critical Hit Cookies</h3>
                    <p>Chocolate chip cookies with 20-sided chocolate pieces</p>
                    <p class="story-meta">HK$ 23 • Sweet • Chocolate</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="wheat"></i></div>
                    <h3>Mana Trail Mix</h3>
                    <p>Mixed nuts, dried fruits, and chocolate gems</p>
                    <p class="story-meta">HK$ 28 • Energy • Mixed</p>
                </article>
            </div>
        </section>

        {{-- Meals --}}
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="swords"></i>
                </div>
                <p class="story-meta">Meals</p>
                <h3>Quest Fuel</h3>
                <p>Substantial meals for extended gaming sessions</p>
            </div>

            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="sandwich"></i></div>
                    <h3>Paladin's Panini</h3>
                    <p>Grilled chicken with pesto, mozzarella, and roasted vegetables</p>
                    <p class="story-meta">HK$ 50 • Grilled • Filling</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="leafy-green"></i></div>
                    <h3>Ranger's Forest Wrap</h3>
                    <p>Whole wheat wrap with turkey, avocado, and fresh greens</p>
                    <p class="story-meta">HK$ 45 • Healthy • Fresh</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="beef"></i></div>
                    <h3>Bard's Burger</h3>
                    <p>Beef patty with caramelized onions, bacon, and special sauce</p>
                    <p class="story-meta">HK$ 58 • Classic • Hearty</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="salad"></i></div>
                    <h3>Mage's Veggie Bowl</h3>
                    <p>Quinoa bowl with roasted vegetables, chickpeas, and tahini</p>
                    <p class="story-meta">HK$ 42 • Vegetarian • Nutritious</p>
                </article>
            </div>
        </section>

        {{-- Desserts --}}
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="gem"></i>
                </div>
                <p class="story-meta">Desserts</p>
                <h3>Sweet Treasures</h3>
                <p>Magical desserts to celebrate your victories</p>
            </div>

            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="cake-slice"></i></div>
                    <h3>Treasure Chest Brownie</h3>
                    <p>Fudgy brownie with gold chocolate coins and hidden gems</p>
                    <p class="story-meta">HK$ 32 • Chocolate • Decadent</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="cake"></i></div>
                    <h3>Enchanted Forest Cake</h3>
                    <p>Chocolate cake with mushroom meringues and moss-green frosting</p>
                    <p class="story-meta">HK$ 38 • Chocolate • Artistic</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="ice-cream-cone"></i></div>
                    <h3>Crystal Cupcake</h3>
                    <p>Vanilla cupcake with crystallized sugar and edible glitter</p>
                    <p class="story-meta">HK$ 20 • Sweet • Sparkling</p>
                </article>
            </div>
        </section>

        {{-- Pre-orderable Board Games --}}
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">
                    <i data-lucide="gamepad-2"></i>
                </div>
                <p class="story-meta">Games</p>
                <h3>Pre-orderable Board Games</h3>
                <p>Reserve your favorite games for your next visit. Available for pre-order with no additional cost.</p>
            </div>

            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="map"></i></div>
                    <h3>Catan: Cities &amp; Knights</h3>
                    <p>An expansion to the classic Catan that adds city development and knight mechanics. Perfect for 3-4 players seeking deeper strategic gameplay.</p>
                    <p class="story-meta">Strategy • 3-4 Players • 90-120 min • Medium</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="feather"></i></div>
                    <h3>Wingspan</h3>
                    <p>Beautiful bird-themed engine building game. Collect birds, food, and eggs to create the most successful wildlife preserve.</p>
                    <p class="story-meta">Engine Building • 1-5 Players • 40-70 min • Light</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="sword"></i></div>
                    <h3>Gloomhaven</h3>
                    <p>Epic tactical combat campaign game. Battle monsters, level up, and explore a massive world in this legacy experience.</p>
                    <p class="story-meta">Campaign • 1-4 Players • 60-120 min • Heavy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="grid-3x3"></i></div>
                    <h3>Azul</h3>
                    <p>Beautiful tile-laying game where players compete to create the most stunning mosaic. Easy to learn, challenging to master.</p>
                    <p class="story-meta">Abstract • 2-4 Players • 30-45 min • Light</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="syringe"></i></div>
                    <h3>Pandemic Legacy: Season 1</h3>
                    <p>Work together to save humanity from deadly diseases in this evolving campaign. Your decisions permanently change the game.</p>
                    <p class="story-meta">Cooperative • 2-4 Players • 45-60 min • Medium</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true"><i data-lucide="globe-2"></i></div>
                    <h3>Terraforming Mars</h3>
                    <p>Compete to make Mars habitable by playing cards and managing resources. Deep strategic gameplay with high replayability.</p>
                    <p class="story-meta">Economic • 1-5 Players • 90-120 min • Medium</p>
                </article>
            </div>
        </section>
    </div>

    <div class="split-panel">
        <div class="panel-section">
            <p class="eyebrow">Special Offers</p>
            <h2 class="section-title">Member Benefits</h2>
            <ul class="check-list">
                <li>20% off all beverages for members on Mondays</li>
                <li>Free coffee with any meal purchase after 6 PM</li>
                <li>Show your winning game board for 10% off desserts</li>
            </ul>
        </div>
        <aside class="status-card">
            <p class="story-meta">Dietary Options</p>
            <h3>Accommodations Available</h3>
            <p>Vegetarian, vegan, and gluten-free options available. Please ask our staff about ingredients and allergens.</p>
            <div class="hero-actions">
                <span class="status-pill" title="Vegetarian">V</span>
                <span class="status-pill" title="Vegan">VG</span>
                <span class="status-pill" title="Gluten-Free">GF</span>
            </div>
        </aside>
    </div>
</div>
@endsection
