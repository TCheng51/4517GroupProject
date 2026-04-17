<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->index('phone', 'members_phone_idx');
            $table->index('is_admin', 'members_is_admin_idx');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex('members_phone_idx');
            $table->dropIndex('members_is_admin_idx');
        });
    }
};
