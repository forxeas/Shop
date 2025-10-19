<?php

namespace App\Livewire\Cart;

use App\Contracts\NotifierInterface;
use App\Services\Carts\CartService;
use App\Services\Carts\CartSummaryService;
use App\Services\ExceptionHandlerService;
use App\Services\Messages\LivewireNotifier;
use Auth;
use Cookie;
use Illuminate\View\View;
use Livewire\Component;

class CartsShow extends Component
{
    protected NotifierInterface       $messageService;
    protected CartService             $cartService;
    protected CartSummaryService      $cartSummaryService;
    protected ExceptionHandlerService $exceptService;
    public                            $cartItems;
    public string $userId;
    public array  $checkedItems = [];
    public string $message      = '';
    public string $type         = 'info';

    public float $total             = 0;
    public float $totalDiscount     = 0;
    public float $totalWithDiscount = 0;

    public function boot
    (
        NotifierInterface $livewireNotifier,
        CartService             $cartService,
        CartSummaryService      $CartSummaryService,
        ExceptionHandlerService $exceptService
    ): void
    {
        /** @var NotifierInterface|LivewireNotifier $livewireNotifier */

        $this->messageService = $livewireNotifier;
        $this->messageService->setComponent($this);
        $this->cartService = $cartService;
        $this->cartSummaryService = $CartSummaryService;
        $this->exceptService = $exceptService;
    }

    public function mount(): void
    {
        $this->userId = Auth::id() ?? $this->cartService->GuestUserId();
        $this->loadCart();
        $this->exceptService->catchToException
        (
            fn() =>($this->checkedItems = $this->cartSummaryService->getCheckedItems()),
            'Произошла ошибка при загрузке выбранных товаров',
            'CartsShow: error to loading checked items from cookie',
        );
        $this->calculateTotal();
    }

    public function incrementQuantity(int $id): void
    {
        $this->exceptService->catchExceptionFinally
        (
            fn () => $this->cartService->increment($id, $this->cartItems),
            'Произошла ошибка при увеличение количества товаров',
            'CartsShow: incrementQuantity error',
            function() {
                $this->calculateTotal();
            }
        );
    }

    public function decrementQuantity(int $id): void
    {
        $this->exceptService->catchExceptionFinally
        (
            fn () => $this->cartService->decrement($id, $this->cartItems),
            'Произошла ошибка при уменьшие количества товаров',
            'CartsShow: decrementQuantity error',
            function() {
                $this->calculateTotal();
            }
        );
    }

    public function deleteProduct(int $id): void
    {
        $this->exceptService->catchExceptionFinally
        (
            fn () => $this->cartService->delete($id),
            'Произошла ошибка при удалении товара',
            'CartsShow: deleteProduct error',
            function() {
                $this->loadCart();
                $this->calculateTotal();
            }
        );
    }

    public function calculateTotal(): void
    {
        $this->exceptService->catchToException
        (
            function() {
                $total = $this->cartSummaryService->calculateTotal($this->userId, $this->cartItems, $this->checkedItems);
                $this->total             = $total['total'];
                $this->totalDiscount     = $total['totalDiscount'];
                $this->totalWithDiscount = $total['totalWithDiscount'];
            },
            'Произошла ошибка при подсчете товара',
            'CartsShow: calculating total is error'
        );
    }

    public function saveSelected(): void
    {
        $this->exceptService->catchToException
        (
            fn() => $this->cartService->saveSelected(Auth::id(), $this->checkedItems),
            'Не удалось сохранить выбранные товары',
            'CartsShow: save selected products error'
        );
    }

    public function selectAll(): void
    {
        $this->exceptService->catchExceptionFinally
        (
            fn() => $this->checkedItems = $this->cartService->selectAll($this->userId, $this->checkedItems),
            'Не удалось выбрать все в корзине',
            'CartShow: error to selected all product',
            function () {
                $this->loadCart();
                $this->calculateTotal();
            }
        );
    }

    public function render(): View
    {
        return view('livewire.cart.carts-show')
            ->title('Корзина');
    }

    private function loadCart(): void
    {
        $this->exceptService->catchToException
        (
            fn () => $this->cartItems = $this->cartSummaryService->getCartItems(),
            'Произошла ошибка при загрузке корзины',
            'Error to load cart'
        );
    }

    public function updatedCheckedItems(): void
    {
        $this->exceptService->catchToException
        (
            fn() => Cookie::queue(
                'checked_items',
                json_encode($this->checkedItems ?: [], JSON_THROW_ON_ERROR),
                60 * 24 * 30),
            'Произошла ошибка при сохранении выбранных товаров',
            'Error saving checked items in cookie',
        );

        $this->calculateTotal();
    }
}
