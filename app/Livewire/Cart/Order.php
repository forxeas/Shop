<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use Livewire\Component;

class Order extends Component
{
    public function render()
    {
        $items = CartItem::query()
            ->where('user_id', auth()->id())
            ->get();

        $total = $items->sum(function ($item) {
            return $item->price * $item->quantity;
        });


        return view('livewire.cart.order')
            ->with(
                [
                    'title', 'Оформление заказа',
                    'items' => $items,
                    'total' => $total,
                ]
            )
            ->title('Оформление заказов');
    }
}
