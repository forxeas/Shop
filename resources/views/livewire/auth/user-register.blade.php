<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <h1 class="mb-4 text-center">Регистрация</h1>
        <form wire:submit="register" class="form-floating">
            @csrf
            <div class="form-floating mb-4">
                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" placeholder="Имя"
                       wire:model.blur="name">
                <label for="name" class="form-label mt-1">Ваше имя</label>
            </div>
            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email"
                       aria-describedby="emailHelp" wire:model.blur="email"
                       placeholder="Почта">
                <label for="email" class="form-label mt-1">Ваша почта</label>
                @error('email')
                <div class="text-danger">{{ $message }}</div> @enderror
                <div id="emailHelp" class="form-text">Мы никогда, не передадим ваши данные.</div>
            </div>
            <div class="form-floating mb-4">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       placeholder="Пароль" wire:model.blur="password">
                <label for="password" class="form-label">Ваш пароль</label>
                @error('password')
                <div class="text-danger">{{ $message }}</div> @enderror
            </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" wire:model="remember">
                        <label class="form-check-label" for="remember">Запомнить меня</label>
                    </div>
            <div class="text-center">
                <button type="submit" class="btn btn-warning mt-4 btn-lg">Сохранить</button>
            </div>
        </form>
    </div>
    <div class="text-center mt-3">
        <p class="mb-0">
            Есть аккаунта?
            <a href="{{ route('register') }}" class="text-decoration-none"> Авторизуйтесь</a>
        </p>
    </div>
</div>
