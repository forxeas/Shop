<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_loaded_and_render(): void
    {
        Livewire::test('auth.user-register')
            ->assertOk()
            ->assertSee('Регистрация');
    }

    public function test_user_can_register(): void
    {
        $this->createUser();

        $this->assertDatabaseHas('users',
            [
                'email' => 'test@example.com',
            ]
        );
    }

    public function test__register_page_hashing_password(): void
    {
        $user = $this->createUser();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_register_page_remember_me(): void
    {
        $user = $this->createUser(['remember' => true]);
        $this->assertNotNull($user->remember_token);
    }

    public function test_register_page_not_remember_me(): void
    {
        $user = $this->createUser();
        $this->assertNull($user->remember_token);
    }

    private function createUser(array $overRides = []): User
    {
        $data = array_merge
        (
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
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
