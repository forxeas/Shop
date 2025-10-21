<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_logout_page_is_render_and_load(): void
    {
        $this->createUser();

        Livewire::test('auth.user-logout')
            ->assertSee('Выход');
    }

    public function  test_logout_user(): void
    {
        $this->createUser();

        Livewire::test('auth.user-logout')
            ->call('logout')
            ->assertRedirect('/');
    }
}
