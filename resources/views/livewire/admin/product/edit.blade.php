<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 ">Редактирование</h1>
        <form wire:submit="save">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название продукта</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name"
                       placholder="Продукт" wire:model.blur="name" value="{{ $product->name  }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание продукта</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          wire:model.blur="description" placeholder="Описание">{{ $product->description }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Цена продукта</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                       placholder="Цена" wire:model.blur="price" value="{{ $product->price }}">
                @error('price')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Автор</label>
                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                       placholder="Автор" wire:model.blur="userName" value="{{ $product->user->name }}">
                @error('author')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Категории</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                       placholder="Категории" wire:model.blur="category" value="{{ $product->category->name }}">
                @error('category')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 ">Сохранить</button>
            </div>
        </form>
    </div>
</div>
