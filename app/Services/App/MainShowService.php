<?php

namespace App\Services\App;

use App\Models\CartItem;
use App\Models\Product;
use http\Exception\RuntimeException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Str;

class MainShowService
{
    private ?string $guestId = null;

    public function addToCart(?string $userId, int $productId): void
    {
        $this->guestId = $userId ? null : $this->generateUserId();

        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);

        CartItem::query()->create(
            [
                'user_id'    => $userId,
                'product_id' => $productId,
                'guest_id'   => $this->guestId,
                'price'      => $product->price,
                'discount'   => $product->discount,
                'quantity'   => 1,
            ]
        );
    }

    public function generateUserId(): string
    {
        if (Cookie::has('cartGuestId')) {
            $this->guestId = Cookie::get('cartGuestId');
            return $this->guestId;
        }

        $this->guestId = (string)Str::uuid();
        Cookie::queue('cartGuestId', $this->guestId, 60 * 24 * 7);

        return $this->guestId;
    }

    public function applySearch
    (
        string $search,
        array $lazyLoad,
        string $orderBy,
        int $perPage
    ): LengthAwarePaginator
    {
        return Product::query()
            ->with($lazyLoad)
            ->orderByDesc($orderBy)
            ->where(function ($q) use($search){
                $q->where('products.name', 'like', "%$search%")
                    ->orWhereHas('category', function ($subQ) use($search) {
                        $subQ->where('categories.name', 'like', "%$search%");
                    });
            })
            ->paginate($perPage);
    }

    public function addedCart(?string $userId, ?string $guestId): array
    {
        $findBy = $userId ? 'user_id' : 'guest_id';
        $find   = $userId ?? $guestId;

        return CartItem::query()
            ->where($findBy, '=', $find)
            ->pluck('product_id')
            ->toArray();
    }
}