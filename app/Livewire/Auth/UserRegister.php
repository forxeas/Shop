<?php

namespace App\Livewire\Auth;

use App\Abstracts\AbstractAuthComponent;
use Illuminate\View\View;
use Livewire\Attributes\Validate;

class UserRegister extends AbstractAuthComponent
{
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:6|max:255')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember;

    public function register(): void
    {
        $validated = $this->validate();
        $remember = $validated['remember'] ?? false;
        unset($validated['remember']);

        $this->exceptionService->catchToException
        (
            fn() => $this->service->registerUser($validated, $remember, $this),
            'Ошибка при регистрации. Попробуйте еще раз.',
            'UserRegister: fail to register user'
        );
    }

    public function render(): View
    {
        return view('livewire.auth.user-register')
            ->title('Регистрация');
    }
}
