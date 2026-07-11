<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="meforyou">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#b87f3a">

    <title>@yield('title', config('app.name', 'ME FOR YOU'))</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-base-200 text-base-content antialiased min-h-screen">
    <div class="min-h-screen flex flex-col">
        {{-- Auth header --}}
        <header class="bg-base-100 border-b border-base-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 font-display text-xl font-semibold">
                    <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU" class="w-9 h-9 object-contain" />
                    <span>ME <span class="text-primary">FOR</span> YOU</span>
                </a>
                <div class="flex items-center gap-4 text-sm">
                    @guest
                        @if (Route::has('login') && !request()->routeIs('login'))
                            <a href="{{ route('login') }}" class="hover:text-primary transition-colors">Login</a>
                        @endif
                        @if (Route::has('register') && !request()->routeIs('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                        @endif
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    @endguest
                </div>
            </div>
        </header>

        <main class="flex-1 flex items-center justify-center p-4 sm:p-8">
            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </main>

        <footer class="text-center py-4 text-xs text-base-content/50">
            © {{ date('Y') }} ME FOR YOU. All rights reserved.
        </footer>
    </div>
</body>
</html>
