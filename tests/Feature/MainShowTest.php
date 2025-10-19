<?php

namespace Tests\Feature;

use App\Livewire\App\MainShow;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class MainShowTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_main_page_is_loaded(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_main_page_render_products(): void
    {
        $user = User::factory()->create();
        Product::factory()->count(3)->create(
            [
                'name' => 'Test Product',
                'user_id'     => $user->id,
                'category_id' => $this->category->id,
            ]);

        Livewire::test(MainShow::class)
            ->assertSee('Test Product');
    }

    public function test_main_page_renders_for_authenticated_user (): void
    {
        Product::factory()->count(3)->create(
            [
                'name' => 'Test Product',
                'user_id'     => $this->user->id,
                'category_id' => $this->category->id,
            ]);
        Livewire::test(MainShow::class)
            ->assertSee('Test Product');
    }

    public function test_that_the_search_field_filters(): void
    {
        Product::factory()->create(
            [
                'name' => 'anything',
                'user_id'     => $this->user->id,
                'category_id' => $this->category->id,
            ]);
        $product = Product::factory()->create(
            [
                'name' => 'UniqueProductName',
                'user_id'     => $this->user->id,
                'category_id' => $this->category->id,
            ]);

        Livewire::test(MainShow::class)
            ->call('changeSearch', 'Unique')
            ->assertSee('UniqueProductName')
            ->assertDontSee('anything');
    }

    public function test_add_to_cart_requires_authentication(): void
    {
        $product = Product::factory()->create
        (
            [
                'user_id' => $this->user->id,
                'category_id' => $this->category->id,
            ]
        );

        Livewire::test(MainShow::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_add_to_cart_does_not_require_authentication(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create
        (
            [
                'user_id' => $user,
                'category_id' => $this->category->id,
            ]
        );

        Livewire::test(MainShow::class)
            ->call('addToCart', $product->id);

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }
}
