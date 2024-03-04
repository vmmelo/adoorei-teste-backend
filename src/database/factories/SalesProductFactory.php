<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesProduct>
 */
class SalesProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sale = Sale::firstOrFail();
        $product = Sale::firstOrFail();
        return [
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'amount' => fake()->randomDigit()
        ];
    }
}
