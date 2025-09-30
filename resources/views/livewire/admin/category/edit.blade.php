<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 ">Редактирование</h1>
        <form wire:submit="save">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название категории</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name"
                       placholder="Продукт" wire:model.blur="name" value="{{ $name }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание категории</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          wire:model.blur="description" placeholder="Описание">{{ $description }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 ">Сохранить</button>
            </div>
        </form>
    </div>
</div>
