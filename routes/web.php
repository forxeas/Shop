<?php

use App\Livewire\Account\PersonalAccount;
use App\Livewire\Account\ProductShow;
use App\Livewire\Admin\App\DashboardShow;
use App\Livewire\App\MainShow;
use App\Livewire\Auth\UserLogin;
use App\Livewire\Auth\UserLogout;
use App\Livewire\Auth\UserRegister;
use App\Livewire\Cart\CartsShow;
use App\Livewire\Cart\Order;
use App\Livewire\Privileges\ProductCreate;
use Illuminate\Support\Facades\Route;

Route::get('/', MainShow::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', UserRegister::class)->name('register');
    Route::get('/login', UserLogin::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/account/{user:slug}', PersonalAccount::class)->name('account');
    Route::get('/logout', UserLogout::class)->name('logout');

    Route::get('/product/create', ProductCreate::class)->name('product.create');
    Route::get('/cart', CartsShow::class)->name('cart');

    Route::get('order', Order::class)->name('order');


    Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:AdminPanel'])->group(function() {
       Route::get('/dashboard', DashboardShow::class)->name('dashboard');

       Route::get('/user/index', \App\Livewire\Admin\User\Index::class)->name('user.index');
       Route::get('/user/edit/{user:slug}',\App\Livewire\Admin\User\Edit::class)->name('user.edit');

       Route::get('/product/index', \App\Livewire\Admin\Product\Index::class)->name('product.index');
       Route::get('/product/edit/{product:slug}',\App\Livewire\Admin\Product\Edit::class)
           ->name('product.edit');

       Route::get('category/index', \App\Livewire\Admin\Category\Index::class)->name('category.index');
       Route::get('category/edit/{category:slug}', \App\Livewire\Admin\Category\Edit::class)
           ->name('category.edit');
    });
});

Route::get('/{product:slug}', ProductShow::class)->name('product');

