<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Enums\PaymentEnum;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\User;
use Auth;
use Cookie;
use DB;
use Illuminate\Support\Collection;
use Throwable;

class OrderService
{
    public function getProduct(string $userId): array
    {
        $orders = CartItem::query()
            ->where('cart_items.selected', '=', 1)
            ->where(function ($builder) use ($userId) {
                $builder
                    ->where('cart_items.user_id', '=', $userId)
                    ->orWhere('cart_items.guest_id', '=', $userId);
            })
            ->get();

        $total = $orders->sum(function ($item) {
            return ($item->price - $item->discount) * $item->quantity;
        });
        return ['orders' => $orders, 'total' => $total];
    }

    public function getUser(): string
    {
        return (string) (Auth::id() ?? Cookie::get('cartGuestId'));
    }

    /**
     * @throws Throwable
     */
    public function sendOrder
    (
        string $userId,
        array  $data,
        bool $rememberPhone,
        float $total,
        PaymentEnum $paymentMethod,
        Collection $products
    ): Order {
        return DB::transaction(static function () use (
            $userId,
            $data,
            $rememberPhone,
            $total,
            $paymentMethod,
            $products
        ) {
            $order = Order::query()
                ->create
                (
                    [
                        'user_id'        => $userId,
                        'address'        => $data['address'],
                        'phone_number'   => $data['phoneNumber'],
                        'total'          => $total,
                        'payment_method' => $paymentMethod,
                    ]
                );
            foreach ($products as $product) {
                OrderItem::query()
                    ->create
                    (
                        [
                            'product_id' => $product->product_id,
                            'order_id'   => $order->id,
                            'quantity'   => $product->quantity,
                            'price'      => $product->price,
                            'discount'   => $product->discount,
                        ]
                    );
            }
            CartItem::query()
                ->where('cart_items.user_id', '=', $userId)
                ->where('cart_items.selected', '=', 1)
                ->delete();

            if ($rememberPhone) {
                User::query()
                    ->where('id', '=', $userId)
                    ->update(['phone_number' => $data['phoneNumber']]);
            }
            return $order;
        });
    }

    public function getPhone(string $userId): string|null
    {
          return (User::query()
                   ->where('id', '=', $userId)
                   ->value('phone_number'));
    }
}