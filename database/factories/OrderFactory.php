<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'address'      => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'total_amount' => fake()->numberBetween(100, 50000),
            'status'       => fake()->randomElement(StatusEnum::getValues()),
        ];
    }
}
