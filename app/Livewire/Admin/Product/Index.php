<?php

namespace App\Livewire\Admin\Product;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as Eloquent;
use Illuminate\Database\Query\Builder;

class Index extends AbstractIndex
{
    public array $arrayFields =
        [
            'products.id'       => 'ID',
            'products.name'     => 'Название продукта',
            'products.price'    => 'Цена продукта',
            'products.discount' => 'Скидка',
            'users.name'        => 'Автор',
            'categories.name'   => 'Название категории',
        ];
    public ?string $fieldName = null;
    public function delete(int $id): void
    {
        Product::query()->where('id', '=',  $id)->delete();
        $this->resetPage();
    }

    protected function applySearch(Eloquent|Builder $query): Eloquent
    {
        if (isset($this->search)) {
            $query = $query
                ->orWhereAny(array_keys($this->arrayFields), 'like', '%' . $this->search . '%');

        }
            return $query;
    }

    protected function baseQuery(): Eloquent
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
