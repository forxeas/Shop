<?php

namespace App\Livewire\Admin\User;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;

class Index extends AbstractIndex
{
    public array  $arrayFields    =
        [
            'users.id'       => 'ID',
            'users.name'     => 'Имя',
            'users.role'     => 'Роль',
            'products_count' => 'Кол-во товаров у продавца'
        ];
    public ?string $fieldName = null;
    public function delete(int $id): void
    {
        User::query()->where('id', '=', $id)->delete();
        $this->resetPage();
    }

    protected function applySearch(Builder $query): Builder
    {
        if (isset($this->search)) {
            $query = $query->where(function($q) {
              $q
                  ->orWhere('users.id', 'like', '%' . $this->search . '%')
                  ->orWhere('users.name', 'like', '%' . $this->search . '%')
                  ->orWhere('users.role', 'like', '%' . $this->search . '%')
                  ->orHaving('products_count', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    protected function baseQuery(): Builder
    {
        return User::query()
            ->leftJoin('products', 'users.id', '=', 'products.user_id')
            ->select('users.*')
            ->addSelect(DB::raw('COUNT(products.id) as products_count'))
            ->groupBy('users.id');
    }

    protected function viewPath(): string
    {
        return 'livewire.admin.user.index';
    }

    protected function title(): string
    {
        return 'Пользователи';
    }

    protected function defaultFieldName(): string
    {
        return 'users.id';
    }
}
