<div>
    <div class="mb-5 ">
        <h1 class=""> {{ Auth::user()->name }} </h1>
    </div>

    <x-show-cards :products="$products"/>
</div>
