<?php

namespace Tests;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Livewire\Livewire;

abstract class TestCase extends BaseTestCase
{
    protected User $user;
    protected Category $category;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->category = Category::factory()->create();
    }

    protected function createUser(array $overRides = []): User
    {
        $data = array_merge
        (
            [
                'name'     => 'Test User',
                'email'    => 'test@example.com',
                'password' => 'password123',
                'remember' => false,
            ], $overRides
        );

        Livewire::test('auth.user-register')
            ->set('name', $data['name'])
            ->set('email', $data['email'])
            ->set('password', $data['password'])
            ->set('remember', $data['remember'])
            ->call('register');

        $user =  User::where('email', $data['email'])->first();
        $this->actingAs($user);
        return $user;
    }

    protected function createCart(array $overRides = []): CartItem
    {
        $user     = $this->createUser();
        $category = Category::factory()->create();

        $product = Product::factory()->create([
            'user_id'     => $user->id,
            'category_id' => $category->id,
            'name'        => 'Test Name',
            'description' => 'Test Description',
        ]);

        $data = array_merge
        (
            [
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'guest_id'   => null,
                'quantity'   => 1,
                'price'      => 1000,
                'discount'   => 500,
                'selected'   => 1,
            ], $overRides
        );

        return CartItem::factory()->create($data);
    }
}
