<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{


    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();

        return [
            'product_id'  => Product::factory(),
            'order_id'    => null,
            'quantity'    => fake()->numberBetween(1, 5),
            'price'       => $product->price,
            'discount'    => $product->discount,
        ];
    }
}
