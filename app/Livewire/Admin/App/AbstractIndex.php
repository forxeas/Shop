<?php

namespace App\Livewire\Admin\App;

use Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

abstract class AbstractIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $fieldName      = 'users.id';
    public string $fieldDirectory = 'desc';

    #[Url]
    public int $limit = 10;

    #[Url]
    public string $search = '';

    abstract public function delete(int $id): void;
    abstract protected function baseQuery(): Builder;
    abstract protected function viewPath(): string;
    abstract protected function title(): string;

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
    protected function applySearch(Builder $query): Builder
    {
        return $query;
    }

    public function render(): View
    {
        $query = $this->baseQuery()
            ->orderby($this->fieldName, $this->fieldDirectory);;

        $query = $this->applySearch($query);
        $items = $query->Paginate($this->limit);

        return view($this->viewPath())
            ->with(['items' => $items])
            ->layout('components.layouts.admin', ['title' => $this->title()]);
    }
}
