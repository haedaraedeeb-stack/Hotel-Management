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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->decimal('price_per_night', 8, 2);
            $table->integer('floor');
            $table->string('view');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
