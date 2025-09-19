<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Auth;
use Exception;
use Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserRegister extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:6|max:255')]
    public string $password = '';

    public function register()
    {
        try{
        $validated = $this->validate();
        $user = User::create(
            [
               'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]
        );

        Auth::login($user);
        $this->reset('name', 'email', 'password');
        session()->flash('success', 'Вы успешно зарегистрировались!');

        return redirect()->route('home',[], 301);
        } catch(Exception $e) {
            session()->flash('error', 'Ошибка при регистрации. Попробуйте еще раз.');
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.auth.user-register');
    }
}
