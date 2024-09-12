<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed positions and departments first
        $this->call(class: [
            PositionSeeder::class,
            DepartmentSeeder::class,
        ]);

        // Seed employees and related tables
        \App\Models\Employee::factory(10)->create()->each(function ($employee) {
            \App\Models\Salary::factory()->create(['id_employee' => $employee->id]);
            \App\Models\Attendance::factory(5)->create(['id_employee' => $employee->id]);
            \App\Models\Leave::factory(2)->create(['id_employee' => $employee->id]);
            \App\Models\Schedule::factory(4)->create(['id_employee' => $employee->id]);
        });
    }
}