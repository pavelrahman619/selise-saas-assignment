<?php

namespace Database\Factories;

use App\Models\EmployeeDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeDetailFactory extends Factory
{
    protected $model = EmployeeDetail::class;

    public function definition(): array
    {
        return [
            'designation' => $this->faker->jobTitle,
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'address' => $this->faker->address,
            'joined_date' => $this->faker->date(),
        ];
    }
}
