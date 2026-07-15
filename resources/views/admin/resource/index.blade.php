@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $statusVariants = [
        'available' => 'success', 'active' => 'success', 'confirmed' => 'success', 'replied' => 'success',
        'rented' => 'info', 'booked' => 'info',
        'pending' => 'warning',
        'inactive' => 'neutral', 'unavailable' => 'error',
    ];
    $extraKeys = collect($items)->first() ? array_diff(array_keys(collect($items)->first()), ['id', 'name', 'status']) : [];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        @if (!empty($description))
            <p class="text-sm text-base-content/60 mt-1">{{ $description }}</p>
        @endif
    </div>

    <x-ui.button variant="primary" onclick="document.getElementById('create-modal').showModal()">
        + Add New
    </x-ui.button>
</div>

<x-ui.card>
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" placeholder="Search {{ strtolower($pageTitle) }}..." class="input input-bordered input-sm w-full sm:max-w-xs" />
        <select class="select select-bordered select-sm w-full sm:w-40">
            <option>All statuses</option>
            <option>Active</option>
            <option>Pending</option>
            <option>Inactive</option>
        </select>
    </div>

    <x-ui.table :empty="'No ' . strtolower($pageTitle) . ' found yet.'">
        <x-slot:head>
            <th>Name</th>
            @foreach ($extraKeys as $key)
                <th>{{ ucfirst($key) }}</th>
            @endforeach
            <th>Status</th>
            <th class="text-right">Actions</th>
        </x-slot:head>

        @foreach ($items as $item)
            <tr>
                <td class="font-medium">{{ $item['name'] }}</td>
                @foreach ($extraKeys as $key)
                    <td>{{ $item[$key] ?? ' ' }}</td>
                @endforeach
                <td>
                    <x-ui.badge :variant="$statusVariants[$item['status']] ?? 'neutral'">
                        {{ ucfirst($item['status']) }}
                    </x-ui.badge>
                </td>
                <td class="text-right">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-xs">⋮</label>
                        <ul tabindex="0" class="dropdown-content menu menu-sm z-10 p-2 shadow bg-base-100 rounded-box w-32 border border-base-300">
                            <li><a>Edit</a></li>
                            <li><a class="text-error">Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-ui.table>
</x-ui.card>

<x-ui.modal id="create-modal" title="Add New {{ Str::singular($pageTitle) }}">
    <p class="text-sm text-base-content/60">This form is a placeholder   connect it to a controller action to persist new records.</p>
    <x-slot:actions>
        <form method="dialog"><x-ui.button variant="ghost">Cancel</x-ui.button></form>
        <x-ui.button variant="primary">Save</x-ui.button>
    </x-slot:actions>
</x-ui.modal>
@endsection
