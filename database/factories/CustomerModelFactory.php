<?php

namespace Database\Factories;

use App\Models\CustomerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerModelFactory extends Factory
{
    protected $model = CustomerModel::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
        ];
    }
}


