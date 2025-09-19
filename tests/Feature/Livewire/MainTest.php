<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Main;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MainTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(Main::class)
            ->assertStatus(200);
    }
}
