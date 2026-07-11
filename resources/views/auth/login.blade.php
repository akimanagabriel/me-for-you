@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Welcome back</h1>
    <p class="text-sm text-base-content/60 mb-6">Sign in to your ME FOR YOU account.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-ui.input
            label="Email Address"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            autofocus
            autocomplete="email"
        />

        <x-ui.input
            label="Password"
            name="password"
            type="password"
            required
            autocomplete="current-password"
        />

        <div class="flex items-center justify-between">
            <label class="label cursor-pointer gap-2 justify-start px-0">
                <input type="checkbox" name="remember" class="checkbox checkbox-sm" {{ old('remember') ? 'checked' : '' }}>
                <span class="label-text">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Forgot password?</a>
            @endif
        </div>

        <x-ui.button type="submit" class="w-full">Login</x-ui.button>
    </form>

    @if (Route::has('register'))
        <p class="text-center text-sm text-base-content/60 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Register</a>
        </p>
    @endif
</x-ui.card>
@endsection
