@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<x-ui.card>
    <h1 class="font-display text-3xl font-semibold mb-1">Verify your email</h1>
    <p class="text-sm text-base-content/60 mb-6">Before proceeding, please check your email for a verification link.</p>

    @if (session('resent'))
        <x-ui.alert type="success" class="mb-4">
            A fresh verification link has been sent to your email address.
        </x-ui.alert>
    @endif

    <p class="text-sm text-base-content/70">
        If you did not receive the email,
        <form method="POST" action="{{ route('verification.resend') }}" class="inline">
            @csrf
            <button type="submit" class="text-primary font-medium hover:underline">click here to request another</button>.
        </form>
    </p>
</x-ui.card>
@endsection
