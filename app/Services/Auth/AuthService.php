<?php

namespace App\Services\Auth;

use App\Models\CartItem;
use App\Models\User;
use Auth;
use Cookie;
use Hash;

class AuthService
{
    public function registerUser(array $data, string $remember): void
    {
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]
        );

        Auth::login($user, $remember);

        if(Cookie::has('cartGuestId')) {
            $cart_id = Cookie::get('cartGuestId');
            CartItem::query()
                ->where('guest_id', $cart_id)
                ->delete();
            Cookie::queue(Cookie::forget('cartGuestId'));
        }
    }
}