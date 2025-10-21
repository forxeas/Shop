<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loaded_and_render(): void
    {
        Livewire::test('auth.user-login')
            ->assertOk()
            ->assertSee('Вход в аккаунт');
    }

    public function test_user_can_login(): void
    {
        $this->createUser();

        Livewire::test('auth.user-login')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('authorization')
            ->assertRedirectToRoute('home');

        $this->assertDatabaseHas('users',
            [
                'email' => 'test@example.com',
            ]
        );
    }

    public function test__login_page_hashing_password(): void
    {
        $user = $this->createUser();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_login_page_remember_me(): void
    {
        $user = $this->createUser(['remember' => true]);

        Livewire::test('auth.user-login')
            ->set('email', $user['email'])
            ->set('password', $user['password'])
            ->set('remember', true)
            ->call('authorization');

        $this->assertDatabaseHas('users',
            [
                'remember_token' => $user['remember_token'],
            ]);
    }

    public function test_login_page_not_remember_me(): void
    {
        $user = $this->createUser();

        Livewire::test('auth.user-login')
            ->set('email', $user['email'])
            ->set('password', $user['password'])
            ->call('authorization');

        $this->assertDatabaseHas('users',
            [
                'remember_token' => $user['remember_token'],
            ]);
    }
}
