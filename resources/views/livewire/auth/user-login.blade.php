<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 text-center">Вход в аккаунт</h1>
        <form wire:submit="authorization" class="form-floating">
            @csrf
            <div class="form-floating mb-4 ">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                        wire:model.lazy="email"
                       placeholder="example@example.com">
                <label for="email">Ваша почта</label>

                @error('email')
                <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placeholder="pa$$word" wire:model.lazy="password">
                <label for="password" class="form-label">Ваш пароль</label>
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" wire:model="remember">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 btn-lg">Сохранить</button>
            </div>
        </form>

        <div class="text-center mt-3 ml-2">
            <p class="mb-0">
                Нет аккаунта?
                <a href="{{ route('register') }}" class="text-decoration-none">Зарегистрируйтесь</a>
            </p>
        </div>
    </div>
</div>
