<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Attendance::class;
    public function definition(): array
    {
        return [
            'id_employee' => Employee::factory(),
            'date' => $this->faker->date,
            'time_in' => $this->faker->time('H:i:s'),
            'time_out' => $this->faker->time('H:i:s'),
            'status' => $this->faker->randomElement(['approved', 'rejected', 'in_process']),
            'notes' => $this->faker->sentence,
        ];
    }
}
