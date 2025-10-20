<?php

namespace App\Services\Auth;

use App\Models\CartItem;
use App\Models\User;
use Auth;
use Cookie;
use Hash;
use Livewire\Component;
use RuntimeException;
use Session;

class AuthService
{
    public function registerUser(array $data, string $remember, Component $component): void
    {
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]
        );

        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('guest_id', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }

        Auth::login($user, $remember);
        session::flash('success', 'Вы успешно cоздали аккаунт!');
        $component->redirectRoute('home');
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
}