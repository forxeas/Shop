<?php

namespace App\Livewire\Auth;

use App\Models\CartItem;
use Auth;
use Cookie;
use Illuminate\View\View;
use Livewire\Component;

class UserLogout extends Component
{
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('cart_id', '=', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }

        redirect()->route('home');
    }

    public function render(): View
    {
        return view('livewire.auth.user-logout');
    }
}
