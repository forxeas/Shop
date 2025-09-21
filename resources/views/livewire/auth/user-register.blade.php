<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 ">Регистрация</h1>
        <form wire:submit="register">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Ваше имя</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" placholder="Имя"
                       wire:model.blur="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Ваша почта</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                       aria-describedby="emailHelp" wire:model.blur="email"
                       placholder="Почта">
                <div id="emailHelp" class="form-text">Мы никогда, не передадим ваши данные.</div>
                @error('email')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Ваш пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placholder="Пароль" wire:model.blur="password">
                @error('password')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{--        <div class="mb-3 form-check">--}}
            {{--            <input type="checkbox" class="form-check-input" id="exampleCheck1">--}}
            {{--            <label class="form-check-label" for="exampleCheck1">Check me out</label>--}}
            {{--        </div>--}}
            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 ">Сохранить</button>
            </div>
        </form>
    </div>
</div>
