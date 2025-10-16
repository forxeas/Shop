<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'address'      => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'total'        => 0,
            'status'       => fake()->randomElement(StatusEnum::getValues()),
        ];
    }

    public function itemWith(int $count = 3): static
    {
        return $this->afterCreating(function(Order $order) use($count) {
            $orderItem = OrderItem::factory($count)->create(['order_id' => $order->id]);

            $total = $orderItem->sum(fn($item) => ($item->price - $item->discount) * $item->quantity);

            $order->update(['total' => $total]);
        });
    }
}
