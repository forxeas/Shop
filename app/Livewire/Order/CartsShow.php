<?php

namespace App\Livewire\Order;

use App\Models\CartItem;
use Auth;
use Livewire\Component;

class CartsShow extends Component
{
    public $cartItems;

    public function mount(): void
    {
        $this->loadCart();
    }

    public function loadCart(): void
    {
        $this->cartItems = CartItem::query()
            ->with(['user', 'product'])
            ->where('cart_items.user_id', '=', Auth::id())
            ->orderByDesc('id')
            ->get();
    }

    public function incrementQuantity(int $id): void
    {
        $item = CartItem::query()->findOrFail($id);
        $item->update(['quantity' => $item->quantity + 1]);

        $this->loadCart();
    }

    public function decrementQuantity(int $id): void
    {
        $item = CartItem::query()->findOrFail($id);

        if($item->quantity < 1) {
            $item->delete();
        }

        $item->update(['quantity' => $item->quantity - 1]);

        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.order.carts-show');
    }
}
