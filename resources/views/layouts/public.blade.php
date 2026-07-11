<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="meforyou">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#b87f3a">

    <title>@yield('title', 'ME FOR YOU | Your Professional Companion')</title>
    <meta name="description" content="@yield('meta_description', 'ME FOR YOU offers trusted housing, event management, and transport services in Kigali, Rwanda.')">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans bg-base-100 text-base-content antialiased">
    <x-layout.public-navbar :transparent="$transparentNav ?? false" />

    <main>
        @yield('content')
    </main>

    <x-layout.footer />

    @stack('scripts')
</body>
</html>
