@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Create your account</h1>
    <p class="text-sm text-base-content/60 mb-6">Join ME FOR YOU in a few seconds.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <x-ui.input
            label="Name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            required
            autofocus
            autocomplete="name"
        />

        <x-ui.input
            label="Email Address"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            autocomplete="email"
        />

        <x-ui.input
            label="Password"
            name="password"
            type="password"
            required
            autocomplete="new-password"
        />

        <x-ui.input
            label="Confirm Password"
            name="password_confirmation"
            type="password"
            required
            autocomplete="new-password"
        />

        <x-ui.button type="submit" class="w-full">Register</x-ui.button>
    </form>

    <p class="text-center text-sm text-base-content/60 mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
    </p>
</x-ui.card>
@endsection
