<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $fieldName = 'users.id';
    public string $fieldDirectory = 'desc';
    public array $arrayFields =
        [
            'users.id' => 'ID',
            'users.name' => 'Имя',
            'users.role' => 'Роль',
            'products_count' => 'Кол-во товаров у продавца'
        ];

    #[Url]
    public int $limit = 10;
    public array $arrayLimits = [10, 25, 50, 100];


    public function mount(): void
    {
        $this->limit = in_array($this->limit, $this->arrayLimits) ? $this->limit : $this->arrayLimits[0];
    }

    public function changeOrderBy(string $field): void
    {
        if($field !== $this->fieldName) {
            $this->fieldName = $field;
        }

        $this->fieldDirectory = $this->fieldDirectory === 'asc' ? 'desc' : 'asc';
        $this->resetPage();
    }

    public function deleteUser(int $id): void
    {
        User::query()->where('id', '=',  $id)->delete();
        $this->resetPage();
    }

    public function changeLimit(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $users = User::query()
            ->withCount(['products'])
            ->orderby($this->fieldName, $this->fieldDirectory)
            ->paginate($this->limit);

        return view('livewire.admin.user-index')
            ->with(['users' => $users])
            ->layout('components.layouts.admin', ['title' => 'Пользователи']);
    }
}
