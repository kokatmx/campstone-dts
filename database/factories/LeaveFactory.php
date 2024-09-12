<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Leave::class;
    public function definition(): array
    {
        return [
            'id_employee' => Employee::factory(),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'reason' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['approved', 'rejected', 'in_process']),
        ];
    }
}
