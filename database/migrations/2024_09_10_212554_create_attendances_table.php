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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('id_attendance');
            $table->unsignedBigInteger('id_employee');
            $table->unsignedBigInteger('id_schedule'); // Link to the schedule
            $table->date('date'); // Automatically assigned based on the schedule
            $table->time('time_in');
            $table->time('time_out');
            $table->enum('status', ['tepat waktu', 'terlambat', 'lembur']);
            $table->enum('shift', ['pagi', 'siang', 'malam'])->after('date');
            $table->text('note')->nullable(); // Notes for the attendance status
            $table->timestamps();

            $table->foreign('id_employee')->references('id_employee')->on('employees')->onDelete('cascade')->index();
            $table->foreign('id_schedule')->references('id_schedule')->on('schedules')->onDelete('cascade')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
