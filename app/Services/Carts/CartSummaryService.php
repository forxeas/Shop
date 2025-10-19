<?php

namespace App\Services\Carts;

use App\Models\CartItem;
use Auth;
use Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class CartSummaryService
{
    public function getCheckedItems(): array
    {
        $cookie = Cookie::get('checked_items');

        if(is_null($cookie)) {
            $checkedItems = CartItem::query()
                ->where('cart_items.user_id', '=', Auth::id())
                ->pluck('id')
                ->toArray();

            $serializeItems = json_encode($checkedItems, JSON_THROW_ON_ERROR);

            Cookie::queue('checked_items', $serializeItems, 60 * 24 * 30);
            return $checkedItems;
        }

        return json_decode($cookie, true, 512, JSON_THROW_ON_ERROR) ?? [ ];
    }

    public function getCartItems(): Collection
    {
        return CartItem::query()
            ->with(['user', 'product'])
            ->where('cart_items.user_id', '=', Auth::id())
            ->orderByDesc('id')
            ->get();
    }

    public function setCartTotal(int $userId, array $total): void
    {
        Cache::put('user: ' . $userId  . 'cart_total', $total, 60);
    }

    public function getCartTotal(int $userId): array
    {
        return Cache::get('user: ' . $userId  . 'cart_total');
    }

        public function calculateTotal(string $userId, Collection $cartItem, array $checkedItem): array
    {
        if (Cache::has('user: ' . $userId  . 'cart_total')) {
            return $this->getCartTotal($userId);
        }

        $products          = $cartItem->whereIn('id', $checkedItem);
        $total             = $products->sum(fn($product) => $product->price * $product->quantity);
        $totalDiscount     = $products->sum(fn($product) => $product->discount * $product->quantity);
        $totalWithDiscount = $products->sum(
            fn($product) => ($product->price - $product->discount) * $product->quantity
        );

        return compact('total', 'totalDiscount', 'totalWithDiscount');
    }
}
