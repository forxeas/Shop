<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public array $searchFields = ['products.name', 'categories.name'];

    public string $fieldDirectory = 'desc';
    public string $fieldName = 'products.id';
    public array $arrayFields =
        [
            'products.id' => 'ID',
            'products.name' => 'Название продукта',
            'products.price' => 'Цена продукта',
            'users.name' => 'Автор',
            'categories.name' => 'Название категории',
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

    public function deleteUser(int $id): void
    {
        Product::query()->where('id', '=',  $id)->delete();
        $this->resetPage();
    }

    public function changeOrderBy(string $field): void
    {
        if($this->fieldName !==  $field) {
            $this->fieldName = $field;
            $this->fieldDirectory = 'asc';
        } else {
            $this->fieldDirectory = $this->fieldDirectory === 'desc' ? 'asc' : 'desc';
        }

        $this->resetPage();
    }

    private function applySearch(Builder $query): Builder
    {
        if (! empty($this->search)) {
            $query = $query
                ->where('products.id', 'like', '%' . $this->search . '%')
                ->orWhere('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.price', 'like', '%' . $this->search . '%')
                ->orWhere('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%');
        }

        return $query;
    }


    public function render(): View
    {
        $query = Product::query()
            ->withCount(['user', 'category'])
            ->orderby($this->fieldName, $this->fieldDirectory);

        $query = $this->applySearch($query);
        $products = $query->Paginate($this->limit);

        return view('livewire.admin.product.index')
            ->with(['products' => $products])
            ->layout('components.layouts.admin', ['title' => 'Товары']);
    }
}
