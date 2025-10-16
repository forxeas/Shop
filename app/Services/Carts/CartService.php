<?php

namespace App\Services\Carts;

use App\Models\CartItem;
use Illuminate\Support\Collection;
use RuntimeException;

class CartService
{
    public function increment(int $id, Collection $cartItems): void
    {
        $item = CartItem::query()->findOrFail($id);
        if (! $item) {
            throw new RuntimeException('Item not found');
        }
        $item->update(['quantity' => $item->quantity + 1]);

        $itemKey = $cartItems->search(fn($product) => $product->id === $id);
        if ($itemKey !== false) {
            $cartItems[$itemKey]->quantity++;
        }
    }

    public function decrement(int $id, Collection $cartItems): void
    {
        $item = CartItem::query()->findOrFail($id);
        if (!$item && $item->quantity < 1) {
            throw new RuntimeException('Item not found');
        }
        $item->update(['quantity' => $item->quantity - 1]);

        $itemKey = $cartItems->search(fn($product) => $product->id === $id);
        if ($itemKey !== false) {
            $cartItems[$itemKey]->quantity--;
        }
    }

    public function delete(int $id): void
    {
        $item = CartItem::query()->findOrFail($id);
        if ($item) {
            $item->delete();
        }
    }

    public function selectAll(int $id, array $checkedId): array
    {
        if(empty($checkedId)) {
         return CartItem::query()
            ->where('cart_items.user_id', '=', $id)
             ->pluck('id')
             ->toArray();
        }

        return [];
    }

    public function saveSelected(int $userId, array $selected): void
    {
        CartItem::query()
            ->where('cart_items.user_id', '=', $userId)
            ->update(['selected' => false]);

        CartItem::query()
            ->where('cart_items.user_id', '=', $userId)
            ->whereIn('cart_items.id', $selected)
            ->update(['selected' => true]);
    }
}
