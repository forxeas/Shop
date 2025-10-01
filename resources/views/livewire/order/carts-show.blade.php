<div class="container py-4 d-flex flex-column min-vh-100">
    @if($message)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-dark-emphasis border-bottom pb-2">Корзина покупок</h1>
        </div>
    </div>

    <div class="flex-grow-1">
        @if($cartItems->count() > 0)
            <div class="row g-4">
                @foreach($cartItems as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <x-app.card-body :product="$item->product" />
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-danger"
                                                wire:click="decrementQuantity({{ $item->id }})"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }} title="Уменьшить количество">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary" disabled>
                                            {{ $item->quantity }}
                                        </button>
                                        <button class="btn btn-outline-success"
                                                wire:click="incrementQuantity({{ $item->id }})"
                                                title="Увеличить количество">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <button class="btn btn-outline-danger"
                                            wire:click="deleteProduct({{ $item->id }})"
                                            title="Удалить товар">
                                        <i class=""><x-tabler-trash /></i>
                                    </button>
                                </div>
                                <div class="text-end fw-bold">
                                    {{ number_format($item->product->price * $item->quantity, 2, '.', ' ') }} ₽
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row h-100">
                <div class="col-12 d-flex flex-column justify-content-center align-items-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted mb-2">Ваша корзина пуста</h3>
                    <p class="lead text-center mb-3">Добавьте товары в корзину для продолжения</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Перейти к покупкам</a>
                </div>
            </div>
        @endif
    </div>

    @if($cartItems->count() > 0)
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-left"></i> Продолжить покупки
                </a>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    Оформить заказ <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @endif
</div>
