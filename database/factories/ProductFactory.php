<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price    = fake()->numberBetween(100, 10000);
        $discount = $price / 2;

        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'name'        => fake()->sentence(2),
            'description' => fake()->text(),
            'image'       => fake()->imageUrl(1280, 720, 'product', true, 'Product'),
            'price'       => $price,
            'discount'    => $discount,
            'selected'    => fake()->numberBetween(0, 1),
        ];
    }
}
