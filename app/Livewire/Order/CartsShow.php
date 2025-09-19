<?php

namespace App\Livewire\Order;

use App\Models\Product;
use Auth;
use Livewire\Component;

class CartsShow extends Component
{
    public $cartItem;

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $this->cartItem = Product::query()->where('products.user_id', '=', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.order.carts-show');
    }
}
