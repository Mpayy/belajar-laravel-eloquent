<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
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
            "id" => "",
            "name" => "",
            "title" => "",
            "salary" => 0
        ];
    }

    public function programmer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                "title" => "Programmer",
                "salary" => 10000000
            ];
        });
    }

    public function seniorProgrammer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                "title" => "Senior Programmer",
                "salary" => 10000000
            ];
        });
    }
}
