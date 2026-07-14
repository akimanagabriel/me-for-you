@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $statusVariants = [
        'available' => 'success',
        'reserved' => 'info',
        'sold' => 'neutral',
        'unavailable' => 'error',
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Manage vehicle listings, pricing, and availability.</p>
    </div>

    <x-ui.button variant="primary" href="{{ route('admin.cars.create') }}">
        + Add New
    </x-ui.button>
</div>

<x-ui.card>
    <form method="GET" action="{{ route('admin.cars.index') }}" class="flex flex-col sm:flex-row gap-3 mb-4">
        <input
            type="text"
            name="search"
            value="{{ $filters['search'] ?? '' }}"
            placeholder="Search cars..."
            class="input input-bordered input-sm w-full sm:max-w-xs"
        />

        <select name="status" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="available" @selected(($filters['status'] ?? '') === 'available')>Available</option>
            <option value="reserved" @selected(($filters['status'] ?? '') === 'reserved')>Reserved</option>
            <option value="sold" @selected(($filters['status'] ?? '') === 'sold')>Sold</option>
            <option value="unavailable" @selected(($filters['status'] ?? '') === 'unavailable')>Unavailable</option>
        </select>

        <select name="body_type" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
            <option value="">All body types</option>
            <option value="sedan" @selected(($filters['body_type'] ?? '') === 'sedan')>Sedan</option>
            <option value="suv" @selected(($filters['body_type'] ?? '') === 'suv')>SUV</option>
            <option value="hatchback" @selected(($filters['body_type'] ?? '') === 'hatchback')>Hatchback</option>
            <option value="coupe" @selected(($filters['body_type'] ?? '') === 'coupe')>Coupe</option>
            <option value="pickup" @selected(($filters['body_type'] ?? '') === 'pickup')>Pickup</option>
            <option value="van" @selected(($filters['body_type'] ?? '') === 'van')>Van</option>
            <option value="convertible" @selected(($filters['body_type'] ?? '') === 'convertible')>Convertible</option>
        </select>

        <x-ui.button type="submit" variant="outline" size="sm">Filter</x-ui.button>

        @if (($filters['search'] ?? '') || ($filters['status'] ?? '') || ($filters['body_type'] ?? ''))
            <x-ui.button href="{{ route('admin.cars.index') }}" variant="ghost" size="sm">Clear</x-ui.button>
        @endif
    </form>

    <x-ui.table :empty="'No cars found yet.'">
        <x-slot:head>
            <th>Car</th>
            <th>Make / Model</th>
            <th>Year</th>
            <th>Price</th>
            <th>Mileage</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </x-slot:head>

        @foreach ($cars as $car)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-12 h-12 rounded-box">
                                <img src="{{ $car->cover_image }}" alt="{{ $car->title }}" />
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.cars.show', $car) }}" class="font-medium hover:text-primary transition-colors">
                                {{ $car->title }}
                            </a>
                            @if ($car->is_featured)
                                <x-ui.badge variant="accent" size="xs" class="ml-1">Featured</x-ui.badge>
                            @endif
                        </div>
                    </div>
                </td>
                <td>{{ $car->make }} {{ $car->model }}</td>
                <td>{{ $car->year }}</td>
                <td>
                    {{ $car->currency }} {{ number_format($car->price) }}
                    @if ($car->price_period !== 'total')
                        <span class="text-base-content/50">/{{ $car->price_period }}</span>
                    @endif
                </td>
                <td>{{ number_format($car->mileage) }} km</td>
                <td>
                    <x-ui.badge :variant="$statusVariants[$car->status] ?? 'neutral'">
                        {{ ucfirst($car->status) }}
                    </x-ui.badge>
                </td>
                <td class="text-right">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-xs">⋮</label>
                        <ul tabindex="0" class="dropdown-content menu menu-sm z-10 p-2 shadow bg-base-100 rounded-box w-32 border border-base-300">
                            <li><a href="{{ route('admin.cars.show', $car) }}">View</a></li>
                            <li><a href="{{ route('admin.cars.edit', $car) }}">Edit</a></li>
                            <li>
                                <form method="POST" action="{{ route('admin.cars.destroy', $car) }}" onsubmit="return confirm('Delete {{ $car->title }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error w-full text-left">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-ui.table>

    {{ $cars->links('components.ui.pagination') }}
</x-ui.card>
@endsection