<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Админка' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<div class="d-flex flex-grow-1">

    <!-- Сайдбар -->
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
        <h4>Админка</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('admin.user.index') }}" wire:navigate>Пользователи</a>
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="" wire:navigate>Товары</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="" wire:navigate>Настройки</a></li>
            <li class="nav-item mt-auto">
                <a class="nav-link text-white" href="{{ route('home') }}" >Назад</a>
            </li>
        </ul>
    </div>

    <!-- Контент -->
    <div class="flex-grow-1 p-3">
        {{ $slot }}
    </div>

</div>

<x-app.footer />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
