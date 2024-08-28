<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(), // Generates a related supplier
            'category_id' => Category::factory(), // Generates a related category
            'name' => $this->faker->word(),
            'sku' => strtoupper($this->faker->unique()->lexify('?????-?????')), // Generates a random SKU like 'ABCD-EFGHI'
            'unitPrice' => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 100
            'reorderLevel' => $this->faker->numberBetween(20, 50), // Random reorder level between 1 and 50
            'description' => $this->faker->sentence(),
        ];
    }
}
