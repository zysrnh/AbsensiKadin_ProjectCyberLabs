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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number'); // Untuk keperluan blast WA
            $table->string('institution')->nullable(); // Instansi / Perusahaan (opsional)
            $table->string('qr_token')->unique(); // Token identitas QR Code
            $table->enum('status', ['registered', 'attended', 'cancelled'])->default('registered');
            $table->timestamp('attended_at')->nullable(); // Waktu check-in absensi
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

