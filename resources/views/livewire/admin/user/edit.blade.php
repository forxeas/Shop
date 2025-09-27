@php
    use App\Enums\RoleEnum;
@endphp
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 ">Редактирование</h1>
        <form wire:submit="save">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" placholder="Имя"
                       wire:model.blur="name" value="{{ $user->name  }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                       aria-describedby="emailHelp" wire:model.blur="email"
                       placholder="Почта">
                @error('email')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль (если не ввести, то останется старый)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placholder="Пароль" wire:model.blur="password">
                @error('password')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Роль</label>
                <select class="form-select @error('role') is-invalid @enderror"
                        wire:model.blur="role">
                    @foreach( RoleEnum::getValues() as $k => $role)
                        <option wire:key="{{ $k }}" value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
                @error('role')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 ">Сохранить</button>
            </div>
        </form>
    </div>
</div>
