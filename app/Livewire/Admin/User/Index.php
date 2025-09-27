<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $fieldName      = 'users.id';
    public string $fieldDirectory = 'desc';
    public array  $arrayFields    =
        [
            'users.id'       => 'ID',
            'users.name'     => 'Имя',
            'users.role'     => 'Роль',
            'products_count' => 'Кол-во товаров у продавца'
        ];

    #[Url]
    public int $limit = 10;

    #[Url]
    public string $search = '';

    public function mount(): void
    {
        $arrayLimits = Config::get('constants.arrayLimit');
        $this->limit = in_array($this->limit, $arrayLimits) ? $this->limit : $arrayLimits[0];
    }

    #[On('changeLimit')]
    public function changeLimit(int $value): void
    {
        $this->limit = $value;
        $this->resetPage();
    }

    #[On('changeSearch')]
    public function changeSearch(string $value): void
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function changeOrderBy(string $field): void
    {
        if ($this->fieldName !== $field) {
            $this->fieldName      = $field;
            $this->fieldDirectory = 'asc';
        } else {
            $this->fieldDirectory = $this->fieldDirectory === 'desc' ? 'asc' : 'desc';
        }

        $this->resetPage();
    }

    public function deleteUser(int $id): void
    {
        User::query()->where('id', '=', $id)->delete();
        $this->resetPage();
    }

    private function applySearch(Builder $query): Builder
    {
        if (! empty($this->search)) {
            $query = $query
                ->where('users.id', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('users.role', 'like', '%' . $this->search . '%')
                ->orWhereRaw(
                    '(select count(*) from products where users.id = products.user_id)
                         like ?', ['%' . $this->search . '%']
                );
        }

        return $query;
    }

    public function render(): View
    {
        $query = User::query()
            ->withCount(['products'])
            ->orderby($this->fieldName, $this->fieldDirectory);

        $query = $this->applySearch($query);
        $users = $query->Paginate($this->limit);

        return view('livewire.admin.user.index')
            ->with(['users' => $users])
            ->layout('components.layouts.admin', ['title' => 'Пользователи']);
    }
}
