<?php

namespace App\Livewire\App;

use App\Models\CartItem;
use App\Models\Product;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Shop'])]
class MainShow extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    #[Url]
    public string $search = '';

    #[On('changeSearch')]
    public function changeSearch($search): void
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function addingToCart(int $productId)
    {
        if (! auth()->check()) {
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

    private function applySearch(Builder $query): Builder
    {
        if (! empty($this->search)) {

            $query = $query
                ->where(function ($q) {
                    $q->where('products.name', 'like', "%{$this->search}%");
                })
                ->orWhereHas('category', function ($q) {
                    $q->where('categories.name', 'like', "%{$this->search}%");
                });
        }
        return $query;
    }

    public function render(): View
    {
        $query = Product::query()
            ->with(['category', 'user'])
            ->orderByDesc('id');

        $query = $this->applySearch($query);

        $products = $query
            ->Paginate(16);

        $addedCart = CartItem::query()
            ->where('user_id', '=', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return view('livewire.app.main-show')->with(['products' => $products, 'addedCart' => $addedCart]);
    }
}
