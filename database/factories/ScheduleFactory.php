<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Schedule::class;
    public function definition(): array
    {
        return [
            'id_employee' => Employee::factory(),
            'date' => $this->faker->date,
            'shift' => $this->faker->randomElement(['morning', 'afternoon', 'night']),
        ];
    }
}
