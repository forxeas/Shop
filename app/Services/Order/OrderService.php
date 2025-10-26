<?php

namespace App\Services\Order;

use App\Models\CartItem;
use Auth;
use Cookie;

class OrderService
{
    public function getProduct(string $userId): array
    {
        $orders = CartItem::query()
            ->where('cart_items.selected', '=', 1)
            ->where(function ($builder) use($userId) {
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
        return Auth::id() ?? Cookie::get('cartGuestId');
    }
}