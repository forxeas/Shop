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
                    <input type="hidden" id="coords" name="coords">
                    <button type="button" class="btn btn-success w-100" wire:click.prevent="sendOrder()">
                        Оплатить
                    </button>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Список товаров</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($orders as $product)
                            <li class="list-group-item d-flex align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <strong>x{{ $product->quantity ?? 1 }}</strong>
                                    <a href="{{ route('product', $product->product->slug) }}"
                                       class="link-offset-2 link-underline link-underline-opacity-10 mb-0">
                                        {{ $product->product->name ?? 'Название товара отсутствует' }}
                                    </a>
                                </div>
                                <div class="flex-grow-1 text-center">
                                    <span>{{ $product->price - $product->discount ?? '0' }} руб.</span>
                                </div>
                                <div>
                                    <img
                                            src="{{ asset('storage/' . $product->product->image) }}"
                                            alt="{{ $product->product->name }}"
                                            style="width:50px; height:auto; object-fit:cover;"
                                    />
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Номер телефона</h5>
                    <input
                            type="tel"
                            class="form-control form-control @error('phoneNumber') is-invalid @enderror"
                            placeholder="+7 (___) ___-__-__"
                            wire:model.blur="phoneNumber"
                            id="phone-input"
                    >
                    @error('phoneNumber')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="checkChecked" checked>
                        <label class="form-check-label" for="checkChecked" wire:model="rememberPhone">
                            Запомнить
                        </label>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Способы оплаты</h5>
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
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <input type="text"
                           class="form-control @error('address') is-invalid @enderror"
                           placeholder="Адрес доставки"
                           wire:model.blur="address">
                    @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div id="map" style="width: 100%; height: 400px; padding: 15px"></div>
                <input type="hidden" id="coords" name="coords">
            </div>
        </div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>


<script src="https://unpkg.com/imask@7/dist/imask.min.js"></script>

<script>
    const phoneInput = document.getElementById('phone-input');
    const mask = IMask(phoneInput, {
        mask: '+{7} (000) 000-00-00',
        lazy: false,
        placeholder: {
            show: 'always'
        }
    });


    phoneInput.addEventListener('blur', () => {

        if (mask.unmaskedValue.length !== 11) {
            phoneInput.value = '';
            @this.set('phoneNumber', '');
            return;
        }

        @this.set('phoneNumber', mask.value);
    });
</script>