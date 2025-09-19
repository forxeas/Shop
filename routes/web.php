<?php

use App\Livewire\Account\PersonalAccount;
use App\Livewire\Auth\UserLogin;
use App\Livewire\Auth\UserLogout;
use App\Livewire\Auth\UserRegister;
use App\Livewire\MainShow;
use App\Livewire\Account\ProductShow;
use App\Livewire\Order\CartsShow;
use App\Livewire\Privileges\ProductCreate;
use Illuminate\Support\Facades\Route;

Route::get('/', MainShow::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', UserRegister::class)->name('register');
    Route::get('/login', UserLogin::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/account/{user}', PersonalAccount::class)->name('account');
    Route::get('/logout', UserLogout::class)->name('logout');

    Route::get('/product/create', ProductCreate::class)->name('product.create');
    Route::get('/cart', CartsShow::class)->name('cart');
});

Route::get('/{product:slug}', ProductShow::class)->name('product');

