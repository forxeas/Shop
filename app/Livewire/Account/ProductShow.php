<?php

namespace App\Livewire\Account;

use App\Models\CartItem;
use App\Models\Product;
use Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductShow extends Component
{

    public Product $product;

    public function addingToCart(int $productId)
    {
        if(! auth()->check()) {
            return $this->redirect(route('login'));
        }

        CartItem::query()->create(
            [
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => 1,
            ]
        );
    }

    public function render(): View
    {
        $product = $this->product->load(['user', 'category']);

        $addedCart  = CartItem::query()
            ->where('product_id', '=', $product->id)
            ->where('user_id', '=', Auth::id())
            ->first();

        return view('livewire.account.product-show')
            ->with(['product' => $product, 'addedCart' => $addedCart])
            ->layout('components.layouts.app', ['title' => $product->name]);
    }
}
