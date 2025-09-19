<div class="row ms-5">

    <div class="row ms-5">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <x-card-body :product="$product" />
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="{{ route('product', $product) }}" class="btn btn-outline-primary " wire:navigate>По
                            подробнее</a>
                        @if(in_array($product->id, $addedCart))
                            <a  href="{{ route('cart') }}" class="btn btn-outline-success" wire:navigate>
                                ✓
                            </a>
                        @else
                            <button class="btn btn-dark-primary"
                                    wire:click.debounce.300ms="addingToCart({{ $product->id }})">🛒
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{ $products->links() }}
    </div>
</div>
