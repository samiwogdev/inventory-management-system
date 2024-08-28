<?php

namespace Database\Factories;

use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderModel>
 */
class OrderModelFactory extends Factory
{
    protected $model = OrderModel::class;
    
    public function definition(): array
    {
        
        // Fetch a random product to retrieve the price
        $product = Product::inRandomOrder()->first();

        return [
            'customerId' => CustomerModel::factory(), // Generates a related customer
            'productId' => $product->id, // Use the random product's ID
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 10
            'description' => $this->faker->sentence(), // Random sentence for description
            'status' => $this->faker->randomElement(['pending', 'approved', 'delivered']), // Random status
            'orderDate' => $this->faker->date(), // Random order date
            'total' => 12500,
        ];
    }
}
