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
        Schema::create('shift_changes', function (Blueprint $table) {
            $table->id('id_shift_changes');
            $table->unsignedBigInteger('id_schedule_from'); // The schedule to be swapped
            $table->unsignedBigInteger('id_schedule_to');   // The schedule replacing it
            $table->enum('status', ['diproses', 'disetujui', 'ditolak']); // Status of the shift change
            $table->timestamps();

            $table->foreign('id_schedule_from')->references('id_schedule')->on('schedules')->onDelete('cascade')->index();
            $table->foreign('id_schedule_to')->references('id_schedule')->on('schedules')->onDelete('cascade')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_changes');
    }
};
