@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Coffee Shop</p>
        <h2 class="section-title">Fable Coffee Shop Menu</h2>
        <p class="page-intro">Fuel your gaming sessions with beverages, snacks, meals, and desserts prepared for long table sessions.</p>
    </section>

    <div class="panel">
        @forelse($menuItemsByCategory as $category => $items)
        @php
        $categoryIcon = match($category) {
        'Beverages' => 'coffee',
        'Snacks' => 'dices',
        'Meals' => 'swords',
        'Desserts' => 'gem',
        'Games' => 'gamepad-2',
        default => 'utensils',
        };
        $itemIcon = match($category) {
        'Beverages' => 'cup-soda',
        'Snacks' => 'cookie',
        'Meals' => 'sandwich',
        'Desserts' => 'cake-slice',
        'Games' => 'dices',
        default => 'utensils',
        };
        @endphp
        <section class="menu-section">
            <header class="menu-section-header">
                <div class="menu-section-icon" aria-hidden="true">
                    <i data-lucide="{{ $categoryIcon }}"></i>
                </div>
                <div class="menu-section-heading">
                    <p class="eyebrow">Category</p>
                    <h3>{{ $category }}</h3>
                </div>
                <p class="menu-section-desc">
                    @if($category === 'Beverages')
                    Drinks for the start of the quest.
                    @elseif($category === 'Snacks')
                    Quick bites that keep the turn order moving.
                    @elseif($category === 'Meals')
                    Heavier plates for longer campaigns.
                    @elseif($category === 'Games')
                    Reserve your favorite games for your next session.
                    @else
                    Sweet rewards for the final round.
                    @endif
                </p>
            </header>

            <div class="menu-grid">
                @foreach($items as $item)
                <article class="menu-item-card">
                    <div class="menu-item-head">
                        <div class="feature-icon" aria-hidden="true">
                            <i data-lucide="{{ $itemIcon }}"></i>
                        </div>
                        <h3>{{ $item->name }}</h3>
                    </div>
                    <p class="menu-item-desc">{{ $item->description }}</p>
                    <div class="menu-item-meta">
                        <span class="menu-item-price">HK$ {{ number_format((float) $item->price, 2) }}</span>
                        @if($item->tags)
                        <span class="menu-item-tags">
                            @foreach($item->tags as $tag)
                            <span class="tag-chip">{{ $tag }}</span>
                            @endforeach
                        </span>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @empty
        <p>No menu items are available right now.</p>
        @endforelse
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