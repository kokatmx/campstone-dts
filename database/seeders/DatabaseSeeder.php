<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'saya',
            'email' => 'saya@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed positions and departments first
        // $this->call(class: [
        //     PositionSeeder::class,
        //     DepartmentSeeder::class,
        // ]);

        // // Seed employees and related tables
        // \App\Models\Employee::factory(10)->create()->each(function ($employee) {
        //     \App\Models\Salary::factory()->create(['id_employee' => $employee->id]);
        //     \App\Models\Attendance::factory(5)->create(['id_employee' => $employee->id]);
        //     \App\Models\Leave::factory(2)->create(['id_employee' => $employee->id]);
        //     \App\Models\Schedule::factory(4)->create(['id_employee' => $employee->id]);
        // });

        DB::table('users')->insert([
            'name' => 'Admin AKU',
            'email' => 'adminku@gmail.com',
            'password' => Hash::make('1234567890'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
