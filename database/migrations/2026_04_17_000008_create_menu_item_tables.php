<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2)->default(0);
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['category', 'is_active', 'sort_order'], 'menu_items_category_active_order_idx');
        });

        Schema::create('reservation_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_item_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('line_total', 8, 2);
            $table->timestamps();
            $table->unique(['reservation_id', 'menu_item_id'], 'reservation_menu_items_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_menu_items');
        Schema::dropIfExists('menu_items');
    }
};
