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
        User::factory()->create([
            'name' => 'aiko',
            'email' => 'aiko@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'ben',
            'email' => 'ben@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'chloe',
            'email' => 'chloe@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::factory()->create([
            'name' => 'david',
            'email' => 'david@example.com',
            'password' => Hash::make('1234567890'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin AKU',
            'email' => 'adminku@gmail.com',
            'password' => Hash::make('1234567890'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('positions')->insert([
            'name' => 'Programmer',
            'description' => 'membuat software',
            'basic_salary' => 8000000,
        ]);
        DB::table('positions')->insert([
            'name' => 'Analis Sistem',
            'description' => 'menganalisa sistem',
            'basic_salary' => 9000000,
        ]);
        DB::table('departments')->insert([
            'name' => 'Teknologi Informasi (IT)',
            'description' => 'informasi teknologi',
        ]);
        DB::table('departments')->insert([
            'name' => 'Keuangan',
            'description' => 'mengatur uang',
        ]);
    }
}