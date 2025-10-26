@php
    use App\Enums\PaymentEnum;
@endphp

<div class="container py-4">
    <h1 class="mb-4 text-dark-emphasis border-bottom pb-2">Отправка заказа</h1>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-3">Итоговая сумма: {{ $total }} руб.</h3>
                    <form action="/order/submit" method="post">
                        @csrf
                        <input type="hidden" id="coords" name="coords">
                        <button type="submit" class="btn btn-success w-100">Оплатить</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Список товаров</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($orders as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('product', $product->product->slug) }}"
                                   class="link-offset-2 link-underline link-underline-opacity-10"
                                >
                                    {{ $product->product->name ?? 'Название товара отсутствует' }}
                                </a>
                                <span>{{ $product->price - $product->dicount ?? '0' }} руб.</span>
                                <img
                                     src="{{ asset('storage/' . $product->product->image) }}"
                                     alt="{{ $product->product->name }}"
                                     style="width:50px; height:auto; object-fit:cover;"
                                />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Способы оплаты</h5>
                    <form>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="cash"
                                   wire:model="payment" value="{{ PaymentEnum::CASH->value }}">
                            <label class="form-check-label" for="cash">
                                Наличными при получении
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="card"
                                   wire:model="payment" value="{{ PaymentEnum::CARD->value }}">
                            <label class="form-check-label" for="card">
                                Оплата картой онлайн
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="spb"
                                   wire:model="payment" value="{{ PaymentEnum::SBP->value }}">
                            <label class="form-check-label" for="spb">
                                Оплата через СБП
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>