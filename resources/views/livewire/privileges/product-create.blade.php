<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4">Добавить продукт</h1>
        <form wire:submit="register" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название продукта</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                       placeholder="Название"
                       wire:model.blur="name">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание продукта</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          wire:model.blur="description"
                          placeholder="Описание"></textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Ваша цена</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price"
                       placeholder="Цена"
                       wire:model.blur="price">
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Выберите подходящую категорию</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                        wire:model.blur="category_id">
                    <option selected>Выберите категорию</option>
                    @foreach($categories as $category)
                        <option wire:key="{{ $category->id }}"
                                value="{{ $category->id  ?? 1}}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ваши изображения</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                       wire:model.live="image">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4">Сохранить</button>
            </div>
        </form>

        @if($image && is_object($image))
            <div class="h-25 mt-3">
                <img src="{{ $image->temporaryUrl() }}" class="img-fluid" alt="Фото">
            </div>
        @endif
    </div>
</div>
