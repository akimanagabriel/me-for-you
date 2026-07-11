@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Confirm password</h1>
    <p class="text-sm text-base-content/60 mb-6">Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <x-ui.input
            label="Password"
            name="password"
            type="password"
            required
            autofocus
            autocomplete="current-password"
        />

        <div class="flex items-center justify-between gap-4">
            <x-ui.button type="submit">Confirm Password</x-ui.button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Forgot your password?</a>
            @endif
        </div>
    </form>
</x-ui.card>
@endsection
