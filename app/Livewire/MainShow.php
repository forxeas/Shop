<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\Product;
use Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MainShow extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function addingToCart(int $productId): void
    {
        dd($productId);
        CartItem::query()->create(
            [
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => 1,
            ]
        );

        session()->flash('success', 'Товар добавлен в корзину!');
    }

    public function render(): View
    {
        $products = Product::query()->with(['category', 'user'])->orderByDesc('id')->paginate(16);
        return view('livewire.main-show')->with(['products' => $products]);
    }
}
