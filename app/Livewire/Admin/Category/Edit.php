<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Category $category;

    #[Validate('required|string|min:1|max:255')]
    public string $name;

    #[Validate('required|string|min:1')]
    public string $description;

    public function mount(): void
    {
        $this->name = $this->category->name;
        $this->description = $this->category->description;
    }

    public function save()
    {
        $data = $this->validate();
        Category::query()
            ->where('categories.id', '=', $this->category->id )
            ->update($data);

        return redirect()->route('admin.category.index');
    }

    public function render()
    {
        return view('livewire.admin.category.edit')
            ->layout('components.layouts.admin', ['title' => 'Редактирование пользователя']);
    }
}
