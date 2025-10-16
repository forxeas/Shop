<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-dark-emphasis border-bottom pb-2">Корзина покупок</h1>
        </div>
    </div>

    @if(!empty($message))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >
            {{ $message }}
            <button type="button" class="btn-close" @click="show = false"></button>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4">
                    @foreach($cartItems as $item)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0">
                                <x-app.card-body :product="$item->product" />
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-danger"
                                                    wire:click.debounce.200ms="decrementQuantity({{ $item->id }})"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                    title="Уменьшить количество">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" disabled>
                                                {{ $item->quantity }}
                                            </button>
                                            <button class="btn btn-outline-success"
                                                    wire:click.debounce.200ms="incrementQuantity({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                                    title="Увеличить количество">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   wire:model.live="checkedItems"
                                                   value="{{ $item->id }}" id="{{ $item->id }}">
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-danger"
                                                    wire:click="deleteProduct({{ $item->id }})"
                                                    wire:model.live="checkedItems"
                                                    title="Удалить товар">
                                                <i>
                                                    <x-tabler-trash/>
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-end fw-bold">
                                        {{ number_format($item->product->price * $item->quantity, 2, '.', ' ') }} ₽
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <button wire:click="selectAll" class="btn btn-outline-secondary w-100 mt-2">
                            Выбрать все/Убрать все
                        </button>
                        <h5 class="card-title">Ваш заказ</h5>
                        <p class="d-flex justify-content-between">
                            <span>Товары:</span>
                            <span class="fw-bold">
                                {{ number_format($total, 2, '.', ' ') }} ₽
                            </span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span>Скидка:</span>
                            <span class="fw-bold text-success">
                                - {{ number_format($totalDiscount, 2, '.', ' ') }} ₽
                            </span>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between fs-5">
                            <span>Итого:</span>
                            <span class="fw-bold text-dark">
                                {{ number_format($totalWithDiscount, 2, '.', ' ') }} ₽
                            </span>
                        </p>
                        <a href="{{ route('order') }}" class="btn btn-primary w-100 btn-lg">
                            Перейти к оплате <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fas fa-arrow-left"></i> Продолжить покупки
                        </a>
                    </div>
                </div>
            </div>
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
