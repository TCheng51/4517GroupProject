<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $table->foreignId('time_slot_id')->nullable()->after('room_id')->constrained()->nullOnDelete();
            $table->string('confirmation_code', 16)->nullable()->unique()->after('status');
            $table->timestamp('confirmed_at')->nullable()->after('confirmation_code');
            $table->timestamp('cancelled_at')->nullable()->after('confirmed_at');
            $table->index(['reservation_date', 'room_id', 'time_slot_id', 'status'], 'reservations_date_room_id_slot_id_status_idx');
        });

        $rooms = DB::table('rooms')->pluck('id', 'slug');
        $timeSlots = DB::table('time_slots')->pluck('id', 'label');

        DB::table('reservations')
            ->orderBy('id')
            ->chunkById(100, function ($reservations) use ($rooms, $timeSlots) {
                foreach ($reservations as $reservation) {
                    DB::table('reservations')
                        ->where('id', $reservation->id)
                        ->update([
                            'room_id' => $rooms[$reservation->table_room] ?? null,
                            'time_slot_id' => $timeSlots[$reservation->time_slot] ?? null,
                            'confirmation_code' => $reservation->confirmation_code ?? 'FB' . str_pad((string) $reservation->id, 8, '0', STR_PAD_LEFT),
                            'confirmed_at' => $reservation->status === 'confirmed' ? now() : null,
                            'cancelled_at' => $reservation->status === 'cancelled' ? now() : null,
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex('reservations_date_room_id_slot_id_status_idx');
            $table->dropConstrainedForeignId('time_slot_id');
            $table->dropConstrainedForeignId('room_id');
            $table->dropUnique(['confirmation_code']);
            $table->dropColumn(['confirmation_code', 'confirmed_at', 'cancelled_at']);
        });
    }
};
