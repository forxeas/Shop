<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <h1 class="h4 text-center mb-3">Подтверждение почты</h1>
        <p class="text-center text-muted mb-4">
            Мы отправили код на вашу почту. Пожалуйста, введите его ниже для подтверждения.
        </p>

        <div class="mb-3">
            <label for="verificationCode" class="form-label">Код подтверждения</label>
            <input type="text"
                   id="verificationCode"
                   class="form-control text-center"
                   maxlength="4"
                   wire:model.defer="code"
                   placeholder="Введите код">
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary" wire:click.prevent="resend">
                Отправить код заново
            </button>
            <button class="btn btn-primary" wire:click.prevent="verify">
                Подтвердить
            </button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-info mt-3 text-center">
                {{ session('message') }}
            </div>
        @endif
        @error('code')
        <div class="alert alert-danger mt-3 text-center">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>