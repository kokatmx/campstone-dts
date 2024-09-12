<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'no_hp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'id_position' => Position::inRandomOrder()->first()->id_position, // Sesuaikan dengan nama kolom
            'id_department' => Department::inRandomOrder()->first()->id_department, // Sesuaikan dengan nama kolom
        ];
    }
}
