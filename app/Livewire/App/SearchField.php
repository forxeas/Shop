<?php

namespace App\Livewire\App;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class SearchField extends Component
{
    public string $search = '';


    public function updatedSearch()
    {
        $this->dispatch('search', $this->search);
    }

    public function render(): View
    {
        $products = Product::query()
            ->select('products.name', 'categories.name')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.name', 'like', "%{$this->search}%")
            ->orWhere('categories.name', 'like', "%{$this->search}%")
            ->paginate(16);

        return view('livewire.app.search-field');
    }
}
