<div class="container py-4">
    <div>
        @if($message)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-dark-emphasis border-bottom pb-2">Корзина покупок</h1>
        </div>
    </div>

    @if($cartItems->count() > 0)
        <div class="row">
            @foreach($cartItems as $item)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow ">
                        <x-card-body :product="$item->product"/>
                        <div class="card-footer shadow">
                            <div class="d-flex justify-content-between align-items-center mb-3">
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
                                <button class="btn btn-danger btn" wire:click="deleteProduct({{ $item->id }})"
                                        title="Удалить из корзины">
                                    <i class=""><x-tabler-trash /></i>
                                </button>
                            </div>

                            <div class="d-grid">
                                @if($item->quantity < 1)
                                    <button class="btn btn-success"
                                            wire:click="incrementQuantity({{ $item->id }})">
                                        Восстановить товар
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Продолжить покупки
                </a>
                <a href="" class="btn btn-primary">
                    Оформить заказ <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <div class="display-6 text-muted mb-4">
                    <i class="fas fa-shopping-cart fa-3x"></i>
                </div>
                <h3 class="text-muted">Ваша корзина пуста</h3>
                <p class="lead">Добавьте товары в корзину для продолжения</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Перейти к покупкам</a>
            </div>
        </div>
    @endif
</div>
