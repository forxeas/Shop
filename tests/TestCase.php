<?php

namespace Tests;

use App\Models\Category;
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

        return User::where('email', $data['email'])->first();
    }
}
