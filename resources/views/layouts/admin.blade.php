<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="meforyou">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#b87f3a">

    <title>@yield('title', config('app.name', 'ME FOR YOU')) | Admin</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans bg-base-200 text-base-content antialiased" x-data="toast()">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col min-h-screen">
            <x-layout.navbar :breadcrumbs="$breadcrumbs ?? []" :title="$pageTitle ?? null" />

            <main class="flex-1 p-4 lg:p-6">
                @if (session('success'))
                    <x-ui.alert type="success" dismissible class="mb-6">{{ session('success') }}</x-ui.alert>
                @endif

                @if (session('error'))
                    <x-ui.alert type="error" dismissible class="mb-6">{{ session('error') }}</x-ui.alert>
                @endif

                @if (session('status'))
                    <x-ui.alert type="info" dismissible class="mb-6">{{ session('status') }}</x-ui.alert>
                @endif

                @yield('content')
            </main>

            <x-layout.footer variant="admin" />
        </div>

        <x-layout.sidebar />
    </div>

    {{-- Toast notifications --}}
    <div class="toast-container" x-cloak>
        <template x-for="toast in toasts" :key="toast.id">
            <div class="alert shadow-lg" :class="{
                'alert-success': toast.type === 'success',
                'alert-error': toast.type === 'error',
                'alert-warning': toast.type === 'warning',
                'alert-info': toast.type === 'info',
            }">
                <span x-text="toast.message"></span>
                <button @click="remove(toast.id)" class="btn btn-ghost btn-xs">✕</button>
            </div>
        </template>
    </div>

    @stack('scripts')
</body>

</html>