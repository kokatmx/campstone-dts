<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Salary::class;

    public function definition(): array
    {
        return [
            'id_employee' => Employee::factory(),
            'basic_salary' => $this->faker->numberBetween(3000, 7000),
            'allowances' => $this->faker->numberBetween(500, 2000),
            'deductions' => $this->faker->numberBetween(100, 500),
            'total_salary' => $this->faker->numberBetween(3000, 7000),
        ];
    }
}
