<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Covers showRoomStatus query: WHERE reservation_date = ? AND status != 'cancelled'
            // GROUP BY table_room, time_slot. Composite index lets the planner do an index scan.
            $table->index(
                ['reservation_date', 'table_room', 'time_slot', 'status'],
                'reservations_date_room_slot_status_idx'
            );

            // Admin filtering by status alone.
            $table->index('status', 'reservations_status_idx');

            // Prevent a single member from booking the same room/slot/date twice.
            // NULL values (guests) are not considered equal in SQL uniqueness, so guest
            // rows remain unconstrained at the DB level — validation handles those.
            $table->unique(
                ['member_id', 'reservation_date', 'time_slot', 'table_room'],
                'reservations_member_slot_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropUnique('reservations_member_slot_unique');
            $table->dropIndex('reservations_date_room_slot_status_idx');
            $table->dropIndex('reservations_status_idx');
        });
    }
};
