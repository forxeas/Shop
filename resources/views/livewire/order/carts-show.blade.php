<div class="row">
    <div>
        <h1 class="--bs-dark-text-emphasis">Корзина:</h1>
    </div>
    @foreach($cartItems as $item)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <x-card-body :product="$item->product" />
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>{{ $item->quantity }}</span>
                    @if($item->quantity ===  0)
                        <button class="btn btn-outline-success" wire:click="incrementQuantity({{ $item->id }})">
                            +1
                        </button>
                    @else
                        <button class="btn btn-outline-danger" wire:click="decrementQuantity({{ $item->id }})">
                            -1
                        </button>
                        <button class="btn btn-outline-success" wire:click="incrementQuantity({{ $item->id }})">
                            +1
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
