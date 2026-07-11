@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Set a new password</h1>
    <p class="text-sm text-base-content/60 mb-6">Choose a strong, new password for your account.</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-ui.input
            label="Email Address"
            name="email"
            type="email"
            value="{{ $email ?? old('email') }}"
            required
            autofocus
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

        <x-ui.button type="submit" class="w-full">Reset Password</x-ui.button>
    </form>
</x-ui.card>
@endsection
