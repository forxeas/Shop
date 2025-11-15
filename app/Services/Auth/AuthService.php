<?php

namespace App\Services\Auth;

use App\Models\CartItem;
use Auth;
use Cookie;
use Livewire\Component;
use RuntimeException;
use Session;
use Str;

class AuthService
{
    public function registerUser(array $data, string $remember, Component $component): void
    {
        session::put('registerData', ['data' => $data, 'remember' => $remember]);
        $component->redirectRoute('verify-mail', ['uuid' => Str::uuid()->toString()]);
    }

    public function loginUser(array $data, ?string $remember, Component $component): void
    {
        if(! Auth::attempt($data, $remember)) {
            throw new RuntimeException('Invalid credentials');
        }
        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('guest_id', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }

        Auth::attempt($data, $remember);
        session::flash('success', 'Вы успешно вошли в аккаунт!');
        $component->redirectRoute('home');
    }

    public function logoutUser(Component $component): void
    {
        Auth::logout();
        session::invalidate();
        session::regenerateToken();

        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('cart_id', '=', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }

        session::flash('success', 'Вы успешно вышли из аккаунта!');
        $component->redirectRoute('home');
    }
}