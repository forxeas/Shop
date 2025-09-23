@props(['product'])

<div class="card-body shadow">
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
             class="img-thumbnail">
    @endif
    <h5 class="card-title">{{ Str::limit($product->name, 25) }}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $product->category->name }}</h6>
    <p class="card-text">
        {{ Str::limit($product->description, 100) }}
    </p>
</div>
