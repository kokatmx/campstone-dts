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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->unsignedBigInteger('id_employee');
            $table->date('date');
            $table->string('shift');
            $table->timestamps();

            $table->foreign('id_employee')->references('id_employee')->on('employees')->onDelete('cascade')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};