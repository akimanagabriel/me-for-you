@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Reset password</h1>
    <p class="text-sm text-base-content/60 mb-6">Enter your email and we'll send you a reset link.</p>

    @if (session('status'))
        <x-ui.alert type="success" class="mb-4">{{ session('status') }}</x-ui.alert>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

        <x-ui.button type="submit" class="w-full">Send Password Reset Link</x-ui.button>
    </form>
</x-ui.card>
@endsection
