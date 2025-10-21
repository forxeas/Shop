<?php

namespace App\Livewire\Auth;

use App\Abstracts\AbstractAuthComponent;
use Illuminate\View\View;

class UserLogout extends AbstractAuthComponent
{

    public function logout(): void
    {
        $this->exceptionHandlerService->catchToException
        (
            fn() => $this->service->logoutUser($this),
            'Произошла ошибка при выходе из аккаунта',
            'UserLogout: Error to logout with account'
        );
    }

    public function render(): View
    {
        return view('livewire.auth.user-logout');
    }
}
