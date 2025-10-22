<?php

namespace App\Livewire\Cart;

use App\Contracts\NotifierInterface;
use App\Enums\PaymentEnum;
use App\Services\Cart\CartService;
use App\Services\ExceptionHandlerService;
use App\Services\Order\OrderService;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

class Order extends Component
{
    protected NotifierInterface       $messageService;
    protected CartService             $cartService;
    protected OrderService            $orderService;
    protected ExceptionHandlerService $exceptService;

    public array              $products = [];
    public string $payment  = PaymentEnum::CASH->value;
    public function boot
    (
        NotifierInterface $notifier,
        CartService $cartService,
        OrderService $orderService,
        ExceptionHandlerService $exceptService
    ): void
    {
        $this->messageService = $notifier;
        $this->messageService->setComponent($this);

        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->exceptService = $exceptService;
    }

    /**
     * @throws Throwable
     */
    public function getProducts(): void
    {
        $this->exceptService->catchToException
        (
            fn() => $this->products = $this->orderService->getProduct(),
            'Произошла ошибка при загрузке товаров для оформления заказа',
            'Order: error to loading products for order'
        );
    }
    public function render(): View
    {
        $this->getProducts();

        return view('livewire.cart.order')
            ->with(
                [
                    'title' => 'Оформление заказа',
                    'items' => $this->products['items'],
                    'total' => $this->products['total'],
                ]
            )
            ->title('Оформление заказов');
    }
}
