@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="font-display text-3xl font-semibold">Dashboard</h1>
        <p class="text-sm text-base-content/60 mt-1">Overview of ME FOR YOU platform activity.</p>
    </div>

    @php
        $widgets = [
            ['label' => 'Total Houses', 'value' => $stats['houses'] ?? 0, 'icon' => '🏠', 'accent' => 'primary'],
            ['label' => 'Total Cars', 'value' => $stats['cars'] ?? 0, 'icon' => '🚗', 'accent' => 'secondary'],
            ['label' => 'Total Events', 'value' => $stats['events'] ?? 0, 'icon' => '🎉', 'accent' => 'accent'],
            ['label' => 'Total Bookings', 'value' => $stats['bookings'] ?? 0, 'icon' => '📅', 'accent' => 'info'],
            ['label' => 'Pending Inquiries', 'value' => $stats['inquiries'] ?? 0, 'icon' => '✉️', 'accent' => 'warning'],
            ['label' => 'Registered Users', 'value' => $stats['users'] ?? 0, 'icon' => '👥', 'accent' => 'success'],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($widgets as $widget)
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="card-body flex-row items-center gap-4 py-5">
                    <div>
                        <p class="text-2xl font-semibold font-display">{{ number_format($widget['value']) }}</p>
                        <p class="text-xs uppercase tracking-wide text-base-content/50">{{ $widget['label'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <x-ui.card title="Quick Links" class="lg:col-span-1">
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('admin.houses.index') }}" class="text-primary hover:underline">Manage Houses</a></li>
                <li><a href="{{ route('admin.cars.index') }}" class="text-primary hover:underline">Manage Cars</a></li>
                <li><a href="{{ route('admin.events.index') }}" class="text-primary hover:underline">Manage Events</a></li>
                <li><a href="{{ route('admin.inquiries.index') }}" class="text-primary hover:underline">View Inquiries</a>
                </li>
            </ul>
        </x-ui.card>

        <x-ui.card title="Recent Inquiries" class="lg:col-span-2">
            <x-ui.table :empty="'No inquiries yet.'">
                <x-slot:head>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Status</th>
                </x-slot:head>
                <tr>
                    <td>John Doe</td>
                    <td>Apartment inquiry</td>
                    <td><x-ui.badge variant="warning">Pending</x-ui.badge></td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>Wedding planning</td>
                    <td><x-ui.badge variant="success">Replied</x-ui.badge></td>
                </tr>
            </x-ui.table>
        </x-ui.card>
    </div>
@endsection