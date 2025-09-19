@props(['products', 'addToCart'])

<div class="row ms-5">

    <div class="row ms-5">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail">
                        @endif
                        <h5 class="card-title">{{ Str::limit($product->name, 25) }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $product->category->name }}</h6>
                        <p class="card-text">
                            {{ Str::limit($product->description, 100) }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="{{ route('product', $product) }}" class="card-link " wire:navigate>По подробнее</a>
                        <a href="#" class="btn btn-dark-primary" wire:click.debounce.300ms="addingToCart($product->id)">🛒</a>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $products->links() }}
    </div>
</div>
