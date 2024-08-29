<?php

namespace Database\Factories;

use App\Models\OrderModel;
use App\Models\Product;
use App\Models\CustomerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderModelFactory extends Factory
{
    protected $model = OrderModel::class;

    public function definition()
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'customerId' => CustomerModel::factory(),
            'productId' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'delivered']),
            'orderDate' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 10, 1000), // Generate a random total
        ];
    }
}
