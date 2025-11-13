<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="d-flex flex-column min-vh-100">

<x-app.nav-bar/>

<main class="flex-fill">
    <div class="container">
        {{ $slot }}
    </div>
</main>
<x-app.footer/>
@livewireScripts
</body>
</html>
