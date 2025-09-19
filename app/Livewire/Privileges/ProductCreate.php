<?php

namespace App\Livewire\Privileges;

use App\Models\Category;
use App\Models\Product;
use Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    #[Validate('required|decimal|min:0')]
    public float $price = 0;

    #[Validate('required|numeric|exists:categories,id')]
    public int $category_id;

    #[Validate('nullable|image|max:2048')]
    public $image = '';

    public $categories;

//    protected $casts = ['price' => 'decimal:2'];

    public function mount():void
    {
        $this->categories = Category::all();
    }
    public function register(): void
    {
        $validated = $this->validate();

        $data =
            [
                'user_id'     => Auth::id(),
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'price'       => $validated['price'],
            ];

        if($validated['image']) {
            $data['image'] = $validated['image']->store('images', 'public');
        }

        Product::query()->create($data);

        $this->reset('name', 'category_id', 'description', 'price', 'image');
    }

    public function render(): View
    {
        return view('livewire.privileges.product-create');
    }
}
