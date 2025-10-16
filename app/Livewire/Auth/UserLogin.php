<?php

namespace App\Livewire\Auth;

use Auth;

use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Log;
use Throwable;

class UserLogin extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8|max:255')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember;

    public function authorization()
    {
        try {
            $validated = $this->validate();
            $remember = $validated['remember'] ?? false;
            unset($validated['remember']);

            if(Auth::attempt($validated, $remember)) {
                session()->flash('success', 'Вы успешно вошли в аккаунт!');
                return redirect()->route('home');
            }

            session()->flash('error', 'Неверный логин или пароль!');
            return redirect()->route('login');

        } catch(Throwable $e) {
            Log::error('Ошибка регистрации: '.$e->getMessage());
            session()->flash('error', 'Ошибка при авторизации. Попробуйте еще раз.');
            return redirect()->route('login');
        }

    }
    public function render(): View
    {
        return view('livewire.auth.user-login')
            ->title('Аутентификация');
    }
}
