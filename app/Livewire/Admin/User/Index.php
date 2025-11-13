<?php

namespace App\Livewire\Admin\User;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder as Eloquent;
use Illuminate\Database\Query\Builder;

class Index extends AbstractIndex
{
    public array  $arrayFields    =
        [
            'users.id'           => 'ID',
            'users.name'         => 'Имя',
            'users.phone_number' => 'Телефон',
            'users.role'         => 'Роль',
            'products_count'     => 'Кол-во товаров у продавца'
        ];
    public ?string $fieldName = null;
    public function delete(int $id): void
    {
        User::query()->where('id', '=', $id)->delete();
        $this->resetPage();
    }

    protected function applySearch(Builder|Eloquent $query): Eloquent
    {
        if (isset($this->search)) {
            $query = $query->where(function($q) {
              $q
                  ->orWhereAny(
                      [
                          'users.id',
                          'users.name',
                          'users.phone_number',
                          'users.role'
                      ], 'like', '%' . $this->search . '%')
                  ->orHaving('products_count', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    protected function baseQuery(): Eloquent
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
