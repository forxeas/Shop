<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product  = Product::query()->inRandomOrder()->first();
        $user     = User::query()->inRandomOrder()->first() ?? User::factory()->create();

        return [
            'user_id'    => $user->id,
            'product_id' => $product->id,
            'quantity'   => fake()->numberBetween(1, 5),
            'price'      => $product->price,
            'discount'   => $product->discount,
            'selected'   => fake()->numberBetween(0, 1)
        ];
    }
}
