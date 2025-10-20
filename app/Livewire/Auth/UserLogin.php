<?php

namespace App\Livewire\Auth;

use App\Contracts\NotifierInterface;
use App\Services\Auth\AuthService;
use App\Services\ExceptionHandlerService;
use App\Services\Messages\LivewireNotifier;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;


class UserLogin extends Component
{
    protected AuthService $service;
    protected NotifierInterface $messageService;
    protected ExceptionHandlerService $exceptionHandlerService;

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8|max:255')]
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

        $this->exceptionHandlerService = $exceptionHandlerService;

        $this->messageService          = $livewireNotifier ;
        $this->messageService->setComponent($this);
        $this->service                 = $authService;

        $this->exceptionHandlerService->boot($this->messageService, $this);
    }

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
