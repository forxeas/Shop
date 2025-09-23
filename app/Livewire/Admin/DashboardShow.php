<?php

namespace App\Livewire\Admin;

use Illuminate\View\View;
use Livewire\Component;

class DashboardShow extends Component
{
    public function render(): View
    {
        return view('livewire.admin.dashboard-show')->layout('components.layouts.admin', ['title' => 'Админка']);
    }
}
