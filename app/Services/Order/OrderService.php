<?php

namespace App\Services\Order;

use App\Models\CartItem;

class OrderService
{
    public function getProduct(): array
    {
        $items = CartItem::query()
            ->where('cart_items.user_id', auth()->id())
            ->where('cart_items.selected', '=', 1)
            ->get();

        $total = $items->sum(function ($item) {
            return ($item->price - $item->discount) * $item->quantity;
        });
        return ['items' => $items, 'total' => $total];
    }
}