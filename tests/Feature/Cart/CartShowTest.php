<?php

namespace Tests\Feature\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CartShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_cart_page_is_render_and_load(): void
    {
        $this->createUser();

        Livewire::test('cart.carts-show')
            ->assertSee('Корзина покупок');
    }

    public function test_cart_shows_empty_message_for_new_user(): void
    {
        $this->createUser();

        Livewire::test('cart.carts-show')
            ->assertSee('Ваша корзина пуста');
    }

    public function test_cart_is_not_empty(): void
    {
        $this->createCart();

        Livewire::test('cart.carts-show')
            ->assertSee('Test Name');
    }

    public function test_guest_can_have_items_in_cart(): void
    {
        $this->createCart(
            [
                'user_id' => null,
                'guest_id' => 1
            ]
        );

        $this->assertDatabaseHas('cart_items', ['guest_id' => 1]);
        $this->assertDatabaseCount('cart_items', 1);
    }

    public function test_user_can_increment_count_item_in_cart(): void
    {
        $cart = $this->createCart();

        Livewire::test('cart.carts-show')
            ->call('incrementQuantity', $cart->product_id)
            ->assertSee('2');
    }

    public function test_user_can_decrement_count_item_in_cart(): void
    {
        $cart = $this->createCart(['quantity' => 2]);

        Livewire::test('cart.carts-show')
            ->call('decrementQuantity', $cart->product_id)
            ->assertSee('1');
    }

    public function test_user_can_deleted_item_in_cart(): void
    {
        $cart = $this->createCart();

        Livewire::test('cart.carts-show')
            ->call('deleteProduct', $cart->product_id)
            ->assertSee('Ваша корзина пуста');
    }

    public function test_cart_show_can_calculate_total(): void
    {
        $this->createCart();

        $component =  Livewire::test('cart.carts-show')
            ->call('calculateTotal');

        $this->assertEquals(1000,  $component->total);
        $this->assertEquals(500,  $component->totalDiscount);
        $this->assertEquals(500,  $component->totalWithDiscount);
    }

    public function test_save_select_into_cart_table(): void
    {
        $this->createCart(['selected' => false]);

        Livewire::test('cart.carts-show')
            ->call('saveSelected');

        $this->assertDatabaseHas('cart_items', ['selected' => true]);
    }

//    public function test_select_all_into_cart(): void
//    {
//        $cart1 = $this->createCart(['selected' => false]);
//        $cart2 = $this->createCart(['selected' => false]);
//
//        $component = Livewire::test('cart.carts-show')
//            ->call('mount')
//            ->call('selectAll');
//
//        $this->assertEqualsCanonicalizing(
//            [$cart1->id, $cart2->id],
//            $component->checkedItems
//        );
//    }
}
