<?php
declare(strict_types=1);

namespace App\Livewire\Cart;


use App\Contracts\NotifierInterface;
use App\Enums\PaymentEnum;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\ExceptionHandlerService;
use App\Services\Order\OrderService;
use Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Session;
use Throwable;

class Order extends Component
{
    protected NotifierInterface       $messageService;
    protected CartService             $cartService;
    protected OrderService            $orderService;
    protected ExceptionHandlerService $exceptionService;

    #[Validate('required|string|max:255')]
    public string             $address;
    #[Validate('required|string|min:18|max:18')]
    public string             $phoneNumber;
    #[Validate('bool')]
    public bool               $rememberPhone = true;
    public string|null        $userId        = '';
    public array              $products      = [];
    public PaymentEnum        $payment       = PaymentEnum::CASH;
    public string             $mark          = '';

    protected function messages(): array
    {
        return [
            'phoneNumber.required' => 'Пожалуйста, укажите номер телефона',
            'phoneNumber.min'      => 'Пожалуйста, укажите номер телефона полностью',
            'phoneNumber.max'      => 'Пожалуйста, укажите номер телефона п2олностью',
            'address.required'     => 'Пожалуйста, укажите адрес',
        ];
    }

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
        $this->phoneNumber = $this->orderService->getPhone($this->userId) ?? '';
    }

    #[On('updateAddress')]
    public function updateAddress($payload): void
    {
        $this->address = $payload['address'];
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

    public function sendOrder(): void
    {
        $validated = $this->validate();
        $rememberPhone  = $validated['rememberPhone'] ?? false;
        unset($validated['rememberPhone']);

        $this->exceptionService->catchToException
        (
            function() use($validated, $rememberPhone) {
                $this->orderService
                    ->sendOrder
                    (
                        $this->userId,
                        $validated,
                        $rememberPhone,
                        $this->products['total'],
                        $this->payment,
                        $this->products['orders']
                    );
                $this->redirectRoute('home');
                session::flash('success', 'Успешно заказано');
                },
            'Произошла ошибка при отправки заказа',
            'Order: error to send orders from database'
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
