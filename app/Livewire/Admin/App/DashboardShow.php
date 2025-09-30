<?php

namespace App\Livewire\Admin\App;

use Illuminate\View\View;
use Livewire\Component;

class DashboardShow extends Component
{
    public function render(): View
    {
        return view('livewire.admin.app.dashboard-show')
            ->layout('components.layouts.admin', ['title' => 'Админка']);
    }
}
