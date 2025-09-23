<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserEdit extends Component
{

public User $user;

#[Validate('required|string|min:2|max:255')]
public string $name;

public string $email = '';

#[Validate('nullable|string|min:2|max:255')]
public string $password = '';

#[Validate('required|min:2|max:255', new Enum(RoleEnum::class))]
public string $role;

    public function mount(): void
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
    }
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'min:2',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
        ];
    }
    public function save()
    {
        $data = $this->validate();

        if(!empty($this->password)) {
            $this->password = Hash::make($this->password);
        } else {
            unset($data[$this->password]);
        }

        session()->flash('success', 'Успешное изменение');
        $this->user->update($data);

        return $this->redirect(route('admin.user.index'));
    }

    public function render(): View
    {

        return view('livewire.admin.user-edit')
            ->layout('components.layouts.admin', ['title' => 'Редактирование пользователя']);
    }
}
