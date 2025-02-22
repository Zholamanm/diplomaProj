<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'position' => $this->faker->word,
            'salary' => $this->faker->randomFloat(2, 30000, 100000), // Adjust salary range as needed
        ];
    }
}
