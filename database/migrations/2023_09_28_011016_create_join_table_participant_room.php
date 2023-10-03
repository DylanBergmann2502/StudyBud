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
        Schema::create('participant_room', function (Blueprint $table) {
            $table->id();
            $table->unique(['room_id', 'participant_id']);
            // $table->foreignId('room_id')->constrained();
            // $table->foreignId('participant_id')->constrained(table: 'users');
            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_room');
    }
};
