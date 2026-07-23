@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $statusVariants = [
        'available' => 'success',
        'rented' => 'info',
        'unavailable' => 'error',
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Manage property listings, viewings, and rental agreements.</p>
    </div>

    <x-ui.button variant="primary" href="{{ route('admin.houses.create') }}">
        + Add New
    </x-ui.button>
</div>

<x-ui.card>
    <form method="GET" action="{{ route('admin.houses.index') }}" class="flex flex-col sm:flex-row gap-3 mb-4">
        <input
            type="text"
            name="search"
            value="{{ $filters['search'] ?? '' }}"
            placeholder="Search houses..."
            class="input input-bordered input-sm w-full sm:max-w-xs"
        />

        <select name="status" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="available" @selected(($filters['status'] ?? '') === 'available')>Available</option>
            <option value="rented" @selected(($filters['status'] ?? '') === 'rented')>Rented</option>
            <option value="unavailable" @selected(($filters['status'] ?? '') === 'unavailable')>Unavailable</option>
        </select>

        <select name="type" class="select select-bordered select-sm w-full sm:w-40" onchange="this.form.submit()">
            <option value="">All types</option>
            <option value="apartment" @selected(($filters['type'] ?? '') === 'apartment')>Apartment</option>
            <option value="villa" @selected(($filters['type'] ?? '') === 'villa')>Villa</option>
            <option value="townhouse" @selected(($filters['type'] ?? '') === 'townhouse')>Townhouse</option>
            <option value="studio" @selected(($filters['type'] ?? '') === 'studio')>Studio</option>
            <option value="bungalow" @selected(($filters['type'] ?? '') === 'bungalow')>Bungalow</option>
        </select>

        <x-ui.button type="submit" variant="outline" size="sm">Filter</x-ui.button>

        @if (($filters['search'] ?? '') || ($filters['status'] ?? '') || ($filters['type'] ?? ''))
            <x-ui.button href="{{ route('admin.houses.index') }}" variant="ghost" size="sm">Clear</x-ui.button>
        @endif
    </form>

    <x-ui.table :empty="'No houses found yet.'">
        <x-slot:head>
            <th>House</th>
            <th>Type</th>
            <th>Location</th>
            <th>Price</th>
            <th>Beds / Baths</th>
            <th class="text-center min-w-[100px]">Featured</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </x-slot:head>

        @foreach ($houses as $house)
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-12 h-12 rounded-box">
                                <img src="{{ $house->cover_image }}" alt="{{ $house->title }}" />
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.houses.show', $house) }}" class="font-medium hover:text-primary transition-colors">
                                {{ $house->title }}
                            </a>
                            @if ($house->is_featured)
                                <x-ui.badge variant="accent" size="xs" class="ml-1">Featured</x-ui.badge>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="capitalize">{{ $house->type }}</td>
                <td>{{ $house->location }}, {{ $house->city }}</td>
                <td>{{ $house->currency }} {{ number_format($house->price) }}/{{ $house->price_period }}</td>
                <td>{{ $house->bedrooms }} bd &middot; {{ $house->bathrooms }} ba</td>

                {{-- Featured Toggle --}}
                <td class="text-center">
                    <form method="POST" action="{{ route('admin.houses.toggle-featured', $house) }}" 
                          class="inline-flex items-center justify-center" 
                          id="toggle-featured-form-{{ $house->id }}">
                        @csrf
                        @method('PUT')
                        <label class="cursor-pointer">
                            <input 
                                type="checkbox" 
                                class="toggle toggle-sm toggle-accent" 
                                {{ $house->is_featured ? 'checked' : '' }}
                                onchange="document.getElementById('toggle-featured-form-{{ $house->id }}').submit();"
                                title="{{ $house->is_featured ? 'Click to unfeature' : 'Click to feature' }}"
                            >
                        </label>
                    </form>
                </td>

                <td>
                    <x-ui.badge :variant="$statusVariants[$house->status] ?? 'neutral'">
                        {{ ucfirst($house->status) }}
                    </x-ui.badge>
                </td>

                <td class="text-right">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-xs">⋮</label>
                        <ul tabindex="0" class="dropdown-content menu menu-sm z-10 p-2 shadow bg-base-100 rounded-box w-32 border border-base-300">
                            <li><a href="{{ route('admin.houses.show', $house) }}">View</a></li>
                            <li><a href="{{ route('admin.houses.edit', $house) }}">Edit</a></li>
                            <li>
                                <form method="POST" action="{{ route('admin.houses.destroy', $house) }}" onsubmit="return confirm('Delete {{ $house->title }}? This cannot be undone.')">
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

    {{ $houses->links('components.ui.pagination') }}
</x-ui.card>

<style>
    /* Ensure toggle is visible and styled */
    .toggle {
        --tglbg: #d1d5db;
        appearance: none;
        -webkit-appearance: none;
        background-color: var(--tglbg);
        cursor: pointer;
        display: inline-block;
        height: 1.25rem;
        width: 2.25rem;
        border-radius: 9999px;
        transition: all 0.15s ease-in-out;
        position: relative;
        flex-shrink: 0;
        border: 1px solid #d1d5db;
    }
    .toggle:checked {
        --tglbg: #b87f3a;  /* gold accent */
        border-color: #b87f3a;
    }
    .toggle:checked.toggle-accent {
        --tglbg: #b87f3a;
        border-color: #b87f3a;
    }
    .toggle:focus-visible {
        outline: 2px solid #b87f3a;
        outline-offset: 2px;
    }
    .toggle-sm:before {
        content: "";
        display: block;
        width: 0.875rem;
        height: 0.875rem;
        background-color: #ffffff;
        border-radius: 9999px;
        transition: all 0.15s ease-in-out;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transform: translateX(0.125rem);
    }
    .toggle-sm:checked:before {
        transform: translateX(1rem);
    }
    .toggle-sm:checked.toggle-accent:before {
        background-color: #ffffff;
    }
</style>
@endsection