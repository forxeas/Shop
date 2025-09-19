<?php

namespace App\Livewire\Account;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductShow extends Component
{

    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function render(): View
    {
        $product = $this->product->load(['user', 'category']);

        return view('livewire.account.product-show')
            ->with('product', $product)
            ->layout('components.layouts.app', ['title' => $product->name]);
    }
}
