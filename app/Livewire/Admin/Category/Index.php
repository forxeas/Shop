<?php

namespace App\Livewire\Admin\Category;

use App\Livewire\Admin\App\AbstractIndex;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class Index extends AbstractIndex
{
    public string $fieldName = 'categories.id';
    public array $arrayFields =
        [
            'categories.id' => 'ID',
            'categories.name' => 'Название категории',
            'products_count' => 'Сколько товаров',
        ];
    public function applySearch(Builder $query): Builder
    {
        if (isset($this->search)) {
            return $query
                ->orWhere('categories.id', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%')
                ->orHaving('products_count', 'like', '%' . $this->search . '%');
        }

        return $query;
    }

    public function delete(int $id): void
    {
        Category::query()
            ->where('id', '=',  $id)
            ->delete();
    }

    protected function baseQuery(): Builder
    {
        return Category::query()->withCount(['products']);
    }

    protected function viewPath(): string
    {
        return 'livewire.admin.category.index';
    }

    protected function title(): string
    {
        return 'Категории';
    }
}
