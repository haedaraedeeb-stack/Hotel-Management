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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'rejected','completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
