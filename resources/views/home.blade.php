@extends('layouts.auth')

@section('title', 'Dashboard')

@section('content')
<x-ui.card class="max-w-lg">
    <h1 class="font-display text-3xl font-semibold mb-4">Dashboard</h1>

    @if (session('status'))
        <x-ui.alert type="success" class="mb-4">{{ session('status') }}</x-ui.alert>
    @endif

    <p class="text-base-content/70">You are logged in.</p>

    <x-ui.button href="{{ route('admin.dashboard') }}" class="mt-6">Go to Admin Dashboard</x-ui.button>
</x-ui.card>
@endsection
