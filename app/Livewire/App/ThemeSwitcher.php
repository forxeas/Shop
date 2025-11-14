<?php

namespace App\Livewire\App;

use Illuminate\View\View;
use Livewire\Component;

class ThemeSwitcher extends Component
{
    public string $darkTheme = 'light';

    public function mount(): void
    {
        $this->darkTheme = request()->cookie('theme', 'light');
    }

    public function switchTheme(): void
    {
        $this->darkTheme = $this->darkTheme === 'light' ? 'dark' : 'light';
        cookie()->queue('theme', $this->darkTheme, 60 * 24 * 30);
        $this->dispatch('theme-changed', theme: $this->darkTheme);
    }

    public function updatedDarkTheme($value): void
    {
        $this->dispatch('theme-changed', theme: $value);
    }

    public function render(): View
    {
        return view('livewire.app.theme-switcher');
    }
}
