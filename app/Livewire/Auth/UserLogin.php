<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Аутентификация'])]
class UserLogin extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|min:8|max:255')]
    public string $password = '';

    public function authorization()
    {
        try {
            $validated = $this->validate();

            $user = User::query()->where('email', $validated['email'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                session()->flash('error', 'Неверный логин или пароль!');
                return redirect()->route('login', [], 301);
            }

            Auth::login($user);
            session()->flash('success', 'Вы успешно вошли в аккаунт!');
            return redirect()->route('home', [], 301);
        } catch(Exception $e) {
            session()->flash('error', 'Ошибка при регистрации. Попробуйте еще раз.');
            return redirect()->back();
        }

    }
    public function render(): View
    {
        return view('livewire.auth.user-login');
    }
}
