<?php

namespace App\Livewire\Admin\User;

use App\Enums\RoleEnum;
use App\Models\User;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;

class Edit extends Component
{

public User $user;

#[Validate('required|string|min:2|max:255')]
public string $name = '';

public string $email = '';

#[Validate('nullable|string|min:2|max:255')]
public string $password = '';

#[Validate('nullable|string|min:18|max:18')]
public string $phoneNumber = '';

#[Validate('required|min:2|max:255', new Enum(RoleEnum::class))]
public string $role;

    public function mount(): void
    {
        $this->name        = $this->user->name;
        $this->email       = $this->user->email;
        $this->phoneNumber = $this->user->phone_number ?? '';
        $this->role        = $this->user->role;
    }
    public function rules(): array
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
            unset($data['password']);
        }

        session::flash('success', 'Успешное изменение');
        $this->user->update
        (
            [
                'name'         => $this->name,
                'email'        => $this->email,
                'phone_number' => $this->phoneNumber,
                'role'         => $this->role,
            ]
        );

        return $this->redirect(route('admin.user.index'));
    }

    public function render(): View
    {

        return view('livewire.admin.user.edit')
            ->layout('components.layouts.admin', ['title' => 'Редактирование пользователя']);
    }
}
