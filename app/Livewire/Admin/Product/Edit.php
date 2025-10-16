<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Product $product;

    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|string|min:2')]
    public string $description = '';

    #[Validate('required|decimal:2')]
    public string $price = '';

    #[Validate('required|string|min:2|max:255')]
    public string $userName;

    #[Validate('required|string|min:2|max:255')]
    public string $category;

    #[Validate('required|image|max:2048')]
    public string $image;

    public function mount(): void
    {
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->price = $this->product->price;
        $this->userName = $this->product->user->name;
        $this->category = $this->product->category->name;
        $this->image = $this->product->image;
    }
    public function save()
    {
        $data = $this->validate();

        $this->product->update([
            'name'        => $data['name'],
            'description' => $data['description'],
            'price'       => $data['price'],
            'image'       => $data['image']
        ]);

        $this->product->user->update([
            'name' => $data['userName'],
        ]);

        $this->product->category->update([
            'name' => $data['category'],
        ]);
        return $this->redirect(route('admin.product.index'));
    }


    public function render(): View
    {
        return view('livewire.admin.product.edit')
            ->layout('components.layouts.admin', ['title' => 'Редактирование пользователя']);
    }
}
