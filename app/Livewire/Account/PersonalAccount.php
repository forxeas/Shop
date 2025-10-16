<?php

namespace App\Livewire\Account;

use App\Models\Product;
use App\Models\User;
use Auth;
use Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PersonalAccount extends Component
{
    public User $user;

    private function getUserProducts(int $id): LengthAwarePaginator
    {
        $page =  request()->get('page', 1);
        $product = Cache::remember('user_products:' . $id . 'page' . $page, 60 * 60, static function() use($id){
            return Product::query()
                ->where('products.user_id', '=', $id)
                ->get();
        });

        return new LengthAwarePaginator(
            $product,
            $product->count(),
            16,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query()
            ]
        );
    }
    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function render()
    {
        $products = $this->getUserProducts($this->user->id);
        return view('livewire.account.personal-account')
            ->with('products', $products)
            ->layout('components.layouts.app', ['title' => Auth::user()->name]);
    }
}
