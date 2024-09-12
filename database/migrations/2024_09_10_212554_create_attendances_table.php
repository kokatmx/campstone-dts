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
            $table->date('date');
            $table->time('time_in');
            $table->time('time_out');
            $table->enum('status', ['approved', 'rejected', 'in_process']);
            $table->text('notes')->nullable(); // Menggunakan text dan nullable
            $table->timestamps();

            $table->foreign('id_employee')->references('id_employee')->on('employees')->onDelete('cascade')->index();
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
