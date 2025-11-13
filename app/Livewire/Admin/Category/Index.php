<?php

namespace App\Livewire\Admin\Category;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as Eloquent;

class Index extends AbstractIndex
{
    public array $arrayFields =
        [
            'categories.id' => 'ID',
            'categories.name' => 'Название категории',
            'products_count' => 'Сколько товаров',
        ];
    public ?string $fieldName = null;
    public function applySearch(Eloquent|Builder $query): Eloquent
    {
        if (isset($this->search)) {
            return $query->where(function($q) {
                $q
                    ->orWhereAny(['categories.id', 'categories.name'], 'like', '%' . $this->search . '%')
                    ->orHaving('products_count', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function delete(int $id): void
    {
        Category::query()
            ->where('id', '=',  $id)
            ->delete();
    }

    protected function baseQuery(): Eloquent
    {
        return Category::query()->withCount('products');
    }

    protected function viewPath(): string
    {
        return 'livewire.admin.category.index';
    }

    protected function title(): string
    {
        return 'Категории';
    }

    protected function defaultFieldName(): string
    {
        return 'categories.id';
    }
}
