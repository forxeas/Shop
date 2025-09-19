<div>
    <div class="mt-5">
        <h1>{{ $product->name }}</h1>
    </div>

    <div class="">
        <h3>{{ $product->category->name }}</h3>
    </div>

    <div class="mt-5">
        <span>
            {{ $product->description }}
        </span>
    </div>

    <div class="mt-5">
        <span>
            {{ $product->user->name }}
        </span>
    </div>

    <div class="mt-5">
        <span>
            <img  src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 200px; height: 200px;">
        </span>
    </div>
</div>
