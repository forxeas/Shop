<div>
    <div class="mb-5 ">
        <h1 class=""> {{ Auth::user()->name }} </h1>
    </div>

    <div class="row ms-5">

        <div class="row ms-5">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <x-app.card-body :product="$product" />
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="{{ route('product', $product) }}" class="btn btn-outline-primary " wire:navigate>По подробнее</a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $products->links() }}
        </div>
    </div>

</div>
