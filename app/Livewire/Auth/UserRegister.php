<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Log;
use Throwable;


#[Layout('components.layouts.app', ['title' => 'Регистрация'])]
class UserRegister extends Component
{
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:6|max:255')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember;

    public function register()
    {
        try{

        $validated = $this->validate();
        $remember = $validated['remember'] ?? false;
        unset($validated['remember']);

        $user = User::create(
            [
               'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]
        );

        Auth::login($user, $remember);

        session()->flash('success', 'Вы успешно зарегистрировались!');
        return redirect()->route('home');

        } catch(Throwable $e) {
            Log::error('Ошибка регистрации: '.$e->getMessage());
            session()->flash('error', 'Ошибка при регистрации. Попробуйте еще раз.');
            return redirect()->route('register');
        }
    }

    public function render(): View
    {
        return view('livewire.auth.user-register');
    }
}
