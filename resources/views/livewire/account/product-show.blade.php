<div class="container my-5">
    <div class="row g-4">
        <div class="col-12">
            <h1 class="display-5 text-primary">{{ $product->name }}</h1>
            <p class="text-muted"><i class="fas fa-tag"></i> {{ $product->category->name }}</p>
        </div>

        <div class="col-lg-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded shadow"
                     style="width: 100%; height: auto; max-height: 500px; object-fit: cover;">
            @else
                <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <span class="text-muted">Изображение отсутствует</span>
                </div>
            @endif
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Описание</h5>
                    <p class="card-text">{{ $product->description }}</p>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Продавец:</small>
                            <p class="mb-0 fw-bold">{{ $product->user->name }}</p>
                        </div>

                        <button class="btn btn-primary" wire:click="addToCart({{ $product->id }})">
                            В корзину
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
