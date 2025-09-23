<?php

namespace App\Livewire\Auth;

use Auth;
use Illuminate\View\View;
use Livewire\Component;

class UserLogout extends Component
{
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        redirect()->route('home');
    }

    public function render(): View
    {
        return view('livewire.auth.user-logout');
    }
}
