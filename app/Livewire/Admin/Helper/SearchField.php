<?php

namespace App\Livewire\Admin\Helper;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

class SearchField extends Component
{
    public string $search = '';


    public function updatedSearch(): void
    {
        $this->dispatch('changeSearch', $this->search);
    }

    public function render(): View
    {
        return view('livewire.app.search-field');
    }
}
