<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Clean up any orphaned session rows whose user_id does not resolve to a member.
        // Necessary before adding the FK so the constraint does not fail on existing data.
        if (Schema::hasTable('sessions') && Schema::hasTable('members')) {
            DB::table('sessions')
                ->whereNotNull('user_id')
                ->whereNotIn('user_id', DB::table('members')->select('id'))
                ->update(['user_id' => null]);
        }

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('members')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
