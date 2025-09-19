<?php

namespace App\Livewire\Account;

use App\Models\Product;
use App\Models\User;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PersonalAccount extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }



    public function render()
    {
        $products = Product::query()->where('products.user_id', '=', $this->user->id)->paginate();
        return view('livewire.account.personal-account')
            ->with('products', $products)
            ->layout('components.layouts.app', ['title' => Auth::user()->name]);
    }
}
