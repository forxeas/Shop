<?php

namespace App\Livewire\Admin\Product;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class Index extends AbstractIndex
{
    public array $arrayFields =
        [
            'products.id' => 'ID',
            'products.name' => 'Название продукта',
            'products.price' => 'Цена продукта',
            'users.name' => 'Автор',
            'categories.name' => 'Название категории',
        ];

    public function delete(int $id): void
    {
        Product::query()->where('id', '=',  $id)->delete();
        $this->resetPage();
    }

    protected function applySearch(Builder $query): Builder
    {
        if (isset($this->search)) {

            $query = $query->where(function($q) {
                $q
                    ->where('products.id', 'like', '%' . $this->search . '%')
                    ->orWhere('products.name', 'like', '%' . $this->search . '%')
                    ->orWhere('products.price', 'like', '%' . $this->search . '%')
                    ->orWhere('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('categories.name', 'like', '%' . $this->search . '%');
                });
            }

        return $query;
    }

    protected function baseQuery(): Builder
    {
        return Product::query()
            ->leftJoin('users', 'users.id', '=', 'products.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*');
    }

    protected function viewPath(): string
    {
        return 'livewire.admin.product.index';
    }

    protected function title(): string
    {
        return 'Товары';
    }

    protected function defaultFieldName(): string
    {
        return 'products.id';
    }
}
