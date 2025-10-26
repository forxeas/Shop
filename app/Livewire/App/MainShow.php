<?php

namespace App\Livewire\App;

use App\Contracts\NotifierInterface;
use App\Services\App\MainShowService;
use App\Services\ExceptionHandlerService;
use App\Services\Message\LivewireNotifier;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MainShow extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected MainShowService $mainShowService;
    protected ExceptionHandlerService $exceptionService;
    protected NotifierInterface $messageService;

    #[Url]
    public string $search = '';
    public ?int $userId = null;
    public ?string $guestId = null;
    public function boot
    (
        NotifierInterface $notifier,
        ExceptionHandlerService $exceptionService,
        MainShowService $MainShowService
    ): void
    {
        $this->userId = Auth::id();

        /** @var NotifierInterface|LivewireNotifier $notifier */

        $this->messageService = $notifier;
        $this->messageService->setComponent($this);
        $this->exceptionService = $exceptionService;
        $this->mainShowService = $MainShowService;

        if(is_null($this->userId)) {
            $this->guestId = $this->mainShowService->generateUserId();
        }
        $this->exceptionService->boot($this->messageService, $this);
    }

    #[On('changeSearch')]
    public function changeSearch($search): void
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function addToCart(int $productId): void
    {
        $this->exceptionService->catchToException
        (
            fn() => $this->mainShowService->addToCart($this->userId,$productId),
            'Не удалось добавить товар в корзину',
            'MainShow: addToCart failed'
        );
    }

    public function render(): View
    {
        $products = $this->search();
        $addedCart = $this->addedCart();

        return view('livewire.app.main-show')
            ->with(['products' => $products, 'addedCart' => $addedCart])
            ->title('shop');
    }

    private function search(): LengthAwarePaginator
    {
        return $this->exceptionService->catchToException
        (
            fn() => $this->mainShowService->applySearch
            ($this->search, ['category', 'user'], 'created_at', 12),
            'Не удалось загрузить товары',
            'MainShow: search products failed'
        );
    }

    private function addedCart(): array
    {
        return $this->exceptionService->catchToException
        (
            fn() => $this->mainShowService->addedCart($this->userId, $this->guestId),
            'Не удалось добавить товары',
            'MainShow: addedCart failed'
        );
    }
}
