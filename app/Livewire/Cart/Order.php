<?php

namespace App\Livewire\Cart;

use App\Contracts\NotifierInterface;
use App\Enums\PaymentEnum;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\ExceptionHandlerService;
use App\Services\Order\OrderService;
use Auth;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

class Order extends Component
{
    protected NotifierInterface       $messageService;
    protected CartService             $cartService;
    protected OrderService            $orderService;
    protected ExceptionHandlerService $exceptionService;

    public string             $userId = '';
    public array              $products = [];
    public string             $payment  = PaymentEnum::CASH->value;
    public function boot
    (
        NotifierInterface $messageService,
        CartService $cartService,
        OrderService $orderService,
        ExceptionHandlerService $exceptionService
    ): void
    {
        $this->messageService = $messageService;
        $this->messageService->setComponent($this);

        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->exceptionService = $exceptionService;

        $this->exceptionService->boot($this->messageService, $this);
    }

    public function mount(): void
    {
        $this->userId = $this->orderService->getUser();
        $this->getProducts();
    }

    /**
     * @throws Throwable
     */
    public function getProducts(): void
    {
        $this->exceptionService->catchToException
        (
            fn() => $this->products = $this->orderService->getProduct($this->userId),
            'Произошла ошибка при загрузке товаров для оформления заказа',
            'Order: error to loading products for order'
        );
    }
    public function render(): View
    {
        return view('livewire.cart.order')
            ->with(
                [
                    'title' => 'Оформление заказа',
                    'orders' => $this->products['orders'] ?? collect(),
                    'total' => $this->products['total'] ?? 0,
                ]
            )
            ->title('Оформление заказов');
    }
}
