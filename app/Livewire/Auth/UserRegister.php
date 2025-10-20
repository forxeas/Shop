<?php

namespace App\Livewire\Auth;

use App\Contracts\NotifierInterface;
use App\Services\Auth\AuthService;
use App\Services\ExceptionHandlerService;
use App\Services\Messages\LivewireNotifier;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserRegister extends Component
{
    protected AuthService $service;
    protected NotifierInterface $messageService;
    protected ExceptionHandlerService $exceptionHandlerService;

    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:6|max:255')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember;

    public function boot
    (
        AuthService             $authService,
        NotifierInterface       $livewireNotifier,
        ExceptionHandlerService $exceptionHandlerService
    ): void
    {
        /** @var NotifierInterface|LivewireNotifier $livewireNotifier */

        $this->messageService          = $livewireNotifier ;
        $this->messageService->setComponent($this);

        $this->service                 = $authService;
        $this->exceptionHandlerService = $exceptionHandlerService;

    }

    public function register(): void
    {
        $validated = $this->validate();
        $remember = $validated['remember'] ?? false;
        unset($validated['remember']);

        $this->exceptionHandlerService->catchToException
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
