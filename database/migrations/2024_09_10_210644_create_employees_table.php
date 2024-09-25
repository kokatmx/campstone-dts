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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id_employee');
            // $table->string('name');
            $table->unsignedBigInteger('id_user'); // Foreign key mengarah ke id_user
            $table->unsignedBigInteger('id_position'); // Foreign key mengarah ke id_position
            $table->unsignedBigInteger('id_department'); // Foreign key mengarah ke id_department
            $table->string('address');
            $table->string('gender');
            $table->string('no_hp');
            // $table->string('email')->unique();
            $table->timestamps();

            $table->foreign('id_position')->references('id_position')->on('positions')->onDelete('cascade')->index();
            $table->foreign('id_department')->references('id_department')->on('departments')->onDelete('cascade')->index();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
