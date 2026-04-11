@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Coffee Shop</p>
        <h2 class="section-title">Fabel Coffee Shop Menu</h2>
        <p class="page-intro">Fuel your gaming sessions with our carefully curated selection of beverages, snacks, and meals inspired by fantasy realms and adventures.</p>
    </section>

    <div class="panel">
        <!-- Coffee & Beverages Section -->
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">☕</div>
                <p class="story-meta">Beverages</p>
                <h3>Coffee & Potions</h3>
                <p>Artisanal brews and magical potions to energize your quests</p>
            </div>
            
            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7.5h16" />
                            <path d="M6 4.5h12v15H6z" />
                            <path d="M9 12h6" />
                        </svg>
                    </div>
                    <h3>Dragon's Breath Espresso</h3>
                    <p>Bold double espresso with a hint of cinnamon and dragon fruit syrup</p>
                    <p class="story-meta">HK$ 28 • Strong • Spicy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8h14l-1.5 9.5h-11z" />
                            <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>
                    <h3>Elven Forest Latte</h3>
                    <p>Smooth latte with matcha, honey, and a touch of lavender</p>
                    <p class="story-meta">HK$ 35 • Floral • Sweet</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m4 16 8-10 8 10" />
                            <path d="M7 13.5V20h10v-6.5" />
                            <path d="M10 10.5h4" />
                        </svg>
                    </div>
                    <h3>Dwarf's Mocha Hammer</h3>
                    <p>Rich mocha with dark chocolate, caramel, and espresso</p>
                    <p class="story-meta">HK$ 32 • Chocolate • Strong</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3.5" />
                            <path d="M19.5 12h1.5" />
                            <path d="M3 12h1.5" />
                            <path d="M12 3v1.5" />
                            <path d="M12 19.5V21" />
                            <path d="m17.3 6.7 1 1" />
                            <path d="m5.7 18.3 1 1" />
                            <path d="m18.3 18.3-1 1" />
                            <path d="m6.7 6.7-1 1" />
                        </svg>
                    </div>
                    <h3>Wizard's Wisdom Tea</h3>
                    <p>Earl grey with bergamot, star anise, and wisdom-enhancing herbs</p>
                    <p class="story-meta">HK$ 23 • Herbal • Aromatic</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 18c2.5-4.5 5-6.5 7-6.5S16.5 13.5 19 18" />
                            <path d="M12 11.5V4" />
                            <path d="m9 7 3-3 3 3" />
                        </svg>
                    </div>
                    <h3>Phoenix Rising Cappuccino</h3>
                    <p>Classic cappuccino with orange zest and a fiery chili kick</p>
                    <p class="story-meta">HK$ 30 • Citrus • Spicy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 20V9l6-5 6 5v11" />
                            <path d="M9.5 20v-6h5v6" />
                        </svg>
                    </div>
                    <h3>Mermaid's Iced Tea</h3>
                    <p>Blue pea flower tea with lemon, mint, and a shimmer of magic</p>
                    <p class="story-meta">HK$ 25 • Refreshing • Colorful</p>
                </article>
            </div>
        </section>

        <!-- Gaming Snacks Section -->
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">🎲</div>
                <p class="story-meta">Snacks</p>
                <h3>Gaming Fuel</h3>
                <p>Quick bites that won't slow down your gameplay</p>
            </div>
            
            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7.5h16" />
                            <path d="M6 4.5h12v15H6z" />
                            <path d="M9 12h6" />
                        </svg>
                    </div>
                    <h3>Dice Roll Pretzels</h3>
                    <p>Salted pretzels shaped like d20s with cheese dip</p>
                    <p class="story-meta">HK$ 18 • Savory • Crunchy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8h14l-1.5 9.5h-11z" />
                            <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>
                    <h3>Health Potion Fruit Cup</h3>
                    <p>Mixed berries with dragon fruit and passion fruit dressing</p>
                    <p class="story-meta">HK$ 20 • Healthy • Sweet</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m4 16 8-10 8 10" />
                            <path d="M7 13.5V20h10v-6.5" />
                            <path d="M10 10.5h4" />
                        </svg>
                    </div>
                    <h3>Critical Hit Cookies</h3>
                    <p>Chocolate chip cookies with 20-sided chocolate pieces</p>
                    <p class="story-meta">HK$ 23 • Sweet • Chocolate</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3.5" />
                            <path d="M19.5 12h1.5" />
                            <path d="M3 12h1.5" />
                            <path d="M12 3v1.5" />
                            <path d="M12 19.5V21" />
                            <path d="m17.3 6.7 1 1" />
                            <path d="m5.7 18.3 1 1" />
                            <path d="m18.3 18.3-1 1" />
                            <path d="m6.7 6.7-1 1" />
                        </svg>
                    </div>
                    <h3>Mana Trail Mix</h3>
                    <p>Mixed nuts, dried fruits, and chocolate gems</p>
                    <p class="story-meta">HK$ 28 • Energy • Mixed</p>
                </article>
            </div>
        </section>

        <!-- Main Meals Section -->
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">⚔️</div>
                <p class="story-meta">Meals</p>
                <h3>Quest Fuel</h3>
                <p>Substantial meals for extended gaming sessions</p>
            </div>
            
            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7.5h16" />
                            <path d="M6 4.5h12v15H6z" />
                            <path d="M9 12h6" />
                        </svg>
                    </div>
                    <h3>Paladin's Panini</h3>
                    <p>Grilled chicken with pesto, mozzarella, and roasted vegetables</p>
                    <p class="story-meta">HK$ 50 • Grilled • Filling</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8h14l-1.5 9.5h-11z" />
                            <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>
                    <h3>Ranger's Forest Wrap</h3>
                    <p>Whole wheat wrap with turkey, avocado, and fresh greens</p>
                    <p class="story-meta">HK$ 45 • Healthy • Fresh</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m4 16 8-10 8 10" />
                            <path d="M7 13.5V20h10v-6.5" />
                            <path d="M10 10.5h4" />
                        </svg>
                    </div>
                    <h3>Bard's Burger</h3>
                    <p>Beef patty with caramelized onions, bacon, and special sauce</p>
                    <p class="story-meta">HK$ 58 • Classic • Hearty</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3.5" />
                            <path d="M19.5 12h1.5" />
                            <path d="M3 12h1.5" />
                            <path d="M12 3v1.5" />
                            <path d="M12 19.5V21" />
                            <path d="m17.3 6.7 1 1" />
                            <path d="m5.7 18.3 1 1" />
                            <path d="m18.3 18.3-1 1" />
                            <path d="m6.7 6.7-1 1" />
                        </svg>
                    </div>
                    <h3>Mage's Veggie Bowl</h3>
                    <p>Quinoa bowl with roasted vegetables, chickpeas, and tahini</p>
                    <p class="story-meta">HK$ 42 • Vegetarian • Nutritious</p>
                </article>
            </div>
        </section>

        <!-- Desserts Section -->
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">💎</div>
                <p class="story-meta">Desserts</p>
                <h3>Sweet Treasures</h3>
                <p>Magical desserts to celebrate your victories</p>
            </div>
            
            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7.5h16" />
                            <path d="M6 4.5h12v15H6z" />
                            <path d="M9 12h6" />
                        </svg>
                    </div>
                    <h3>Treasure Chest Brownie</h3>
                    <p>Fudgy brownie with gold chocolate coins and hidden gems</p>
                    <p class="story-meta">HK$ 32 • Chocolate • Decadent</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8h14l-1.5 9.5h-11z" />
                            <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>
                    <h3>Enchanted Forest Cake</h3>
                    <p>Chocolate cake with mushroom meringues and moss-green frosting</p>
                    <p class="story-meta">HK$ 38 • Chocolate • Artistic</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m4 16 8-10 8 10" />
                            <path d="M7 13.5V20h10v-6.5" />
                            <path d="M10 10.5h4" />
                        </svg>
                    </div>
                    <h3>Crystal Cupcake</h3>
                    <p>Vanilla cupcake with crystallized sugar and edible glitter</p>
                    <p class="story-meta">HK$ 20 • Sweet • Sparkling</p>
                </article>
            </div>
        </section>

        <!-- Pre-orderable Board Games Section -->
        <section class="menu-section">
            <div class="story-card">
                <div class="story-icon" aria-hidden="true">🎮</div>
                <p class="story-meta">Games</p>
                <h3>Pre-orderable Board Games</h3>
                <p>Reserve your favorite games for your next visit. Available for pre-order with no additional cost.</p>
            </div>
            
            <div class="cards-grid">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7.5h16" />
                            <path d="M6 4.5h12v15H6z" />
                            <path d="M9 12h6" />
                        </svg>
                    </div>
                    <h3>Catan: Cities & Knights</h3>
                    <p>An expansion to the classic Catan that adds city development and knight mechanics. Perfect for 3-4 players seeking deeper strategic gameplay.</p>
                    <p class="story-meta">Strategy • 3-4 Players • 90-120 min • Medium</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 8h14l-1.5 9.5h-11z" />
                            <path d="M8 8V6.5A3.5 3.5 0 0 1 11.5 3h1A3.5 3.5 0 0 1 16 6.5V8" />
                            <path d="M9 13h6" />
                        </svg>
                    </div>
                    <h3>Wingspan</h3>
                    <p>Beautiful bird-themed engine building game. Collect birds, food, and eggs to create the most successful wildlife preserve.</p>
                    <p class="story-meta">Engine Building • 1-5 Players • 40-70 min • Light</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m4 16 8-10 8 10" />
                            <path d="M7 13.5V20h10v-6.5" />
                            <path d="M10 10.5h4" />
                        </svg>
                    </div>
                    <h3>Gloomhaven</h3>
                    <p>Epic tactical combat campaign game. Battle monsters, level up, and explore a massive world in this legacy experience.</p>
                    <p class="story-meta">Campaign • 1-4 Players • 60-120 min • Heavy</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3.5" />
                            <path d="M19.5 12h1.5" />
                            <path d="M3 12h1.5" />
                            <path d="M12 3v1.5" />
                            <path d="M12 19.5V21" />
                            <path d="m17.3 6.7 1 1" />
                            <path d="m5.7 18.3 1 1" />
                            <path d="m18.3 18.3-1 1" />
                            <path d="m6.7 6.7-1 1" />
                        </svg>
                    </div>
                    <h3>Azul</h3>
                    <p>Beautiful tile-laying game where players compete to create the most stunning mosaic. Easy to learn, challenging to master.</p>
                    <p class="story-meta">Abstract • 2-4 Players • 30-45 min • Light</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 18c2.5-4.5 5-6.5 7-6.5S16.5 13.5 19 18" />
                            <path d="M12 11.5V4" />
                            <path d="m9 7 3-3 3 3" />
                        </svg>
                    </div>
                    <h3>Pandemic Legacy: Season 1</h3>
                    <p>Work together to save humanity from deadly diseases in this evolving campaign. Your decisions permanently change the game.</p>
                    <p class="story-meta">Cooperative • 2-4 Players • 45-60 min • Medium</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 20V9l6-5 6 5v11" />
                            <path d="M9.5 20v-6h5v6" />
                        </svg>
                    </div>
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
                <span class="status-pill">V</span>
                <span class="status-pill">VG</span>
                <span class="status-pill">GF</span>
            </div>
        </aside>
    </div>
</div>

@endsection
