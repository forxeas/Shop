<?php

namespace App\Livewire\Auth;

use App\Abstracts\AbstractAuthComponent;
use Illuminate\View\View;
use Livewire\Attributes\Validate;

class UserLogin extends AbstractAuthComponent
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8|max:255')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember;

    public function authorization(): void
    {
        $validated = $this->validate();
        $remember  = $validated['remember'] ?? false;
        unset($validated['remember']);

        $this->exceptionHandlerService->catchToException
        (
            fn() => $this->service->loginUser($validated, $remember, $this),
            'Не правильный пароль или логин.',
            'UserLogin: fail to login user'
        );
    }
    public function render(): View
    {
        return view('livewire.auth.user-login')
            ->title('Аутентификация');
    }
}
