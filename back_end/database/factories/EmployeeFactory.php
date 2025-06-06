<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "first_name" => $this->faker->name,
            "last_name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "phone" => $this->faker->phoneNumber,
            "type" => "STUFF",
            "hire_date" => $this->faker->date(),
            "created_by" => 1, // Assuming user with ID 1 exists
            "updated_by" => 1, // Assuming user with ID 1 exists

            //
        ];
    }
}
