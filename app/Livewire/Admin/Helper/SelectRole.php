<?php

namespace App\Livewire\Admin\Helper;

use Config;
use Illuminate\View\View;
use Livewire\Component;

class SelectRole extends Component
{
    public int $limit = 10;
    public function updatedLimit(): void
    {
        $this->dispatch('changeLimit', $this->limit);
    }

    public function render(): View
    {
        $arrayLimit = Config::get('constants.arrayLimit');

        return view('livewire.admin.helper.select-role')->with('arrayLimits', $arrayLimit);
    }
}
