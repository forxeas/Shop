<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class SearchField extends Component
{
    public string $search = '';


    public function updatedSearch()
    {
        $this->dispatch('search', $this->search);
    }

    public function render()
    {
        $products = Product::query()
            ->select('products.name', 'categories.name')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.name', 'like', "%{$this->search}%")
            ->orWhere('categories.name', 'like', "%{$this->search}%")
            ->paginate(16);

        return view('livewire.search-field');
    }
}
