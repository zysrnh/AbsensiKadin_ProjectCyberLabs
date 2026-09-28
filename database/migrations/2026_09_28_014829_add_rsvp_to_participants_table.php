<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->enum('rsvp_status', ['pending', 'confirmed_yes', 'confirmed_no'])->default('pending')->after('status');
            $table->timestamp('rsvp_at')->nullable()->after('rsvp_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['rsvp_status', 'rsvp_at']);
        });
    }
};
