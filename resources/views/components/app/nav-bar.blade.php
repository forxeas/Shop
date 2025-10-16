@php use App\Models\Product;use App\Models\User; @endphp
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}" wire:navigate>Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('register') }}" wire:navigate>Регистрация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('login') }}" wire:navigate>Вход</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('account', auth()->user()->slug) }}" wire:navigate
                            >
                                Личный кабинет
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('cart') }}" wire:navigate>Корзина</a>
                        </li>
                        <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link active" onclick="window.history.back();">
                                    Назад
                                </a>
                        </li>
                        <li class="nav-item">
                            <livewire:auth.user-logout/>
                        </li>
                    @endauth
                    @can('view-any', Product::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Действия
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('product.create') }}" wire:navigate>
                                        Добавить товар
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" wire:navigate>
                                        Редактирование продуктов</a>
                                </li>
                                @can('AdminPanel', User::class)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}" wire:navigate>
                                            Админка
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                </ul>
                <livewire:admin.helper.search-field />
            </div>
        </div>
    </nav>
    <div class="my-3">
        <x-app.success />
        <x-app.error />
    </div>
</div>



