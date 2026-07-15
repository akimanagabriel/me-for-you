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
    $featureLabels = [
        'ac' => 'Air Conditioning', 'bluetooth' => 'Bluetooth', 'sunroof' => 'Sunroof',
        'backup_camera' => 'Backup Camera', 'leather_seats' => 'Leather Seats', 'navigation' => 'Navigation',
        'cruise_control' => 'Cruise Control', 'heated_seats' => 'Heated Seats', 'keyless_entry' => 'Keyless Entry',
        'parking_sensors' => 'Parking Sensors', 'alloy_wheels' => 'Alloy Wheels', 'third_row_seats' => 'Third Row Seats',
    ];
    $conditionLabels = [
        'new' => 'New', 'used' => 'Used', 'certified_pre_owned' => 'Certified Pre-Owned',
    ];
    $gallery = $car->images->count() ? $car->images : collect();
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.cars.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Cars</a>

        <div class="flex flex-wrap items-center gap-2 mt-2">
            <h1 class="font-display text-3xl font-semibold">{{ $car->title }}</h1>
            <x-ui.badge :variant="$statusVariants[$car->status] ?? 'neutral'">{{ ucfirst($car->status) }}</x-ui.badge>
            @if ($car->is_featured)
                <x-ui.badge variant="accent">Featured</x-ui.badge>
            @endif
        </div>
        <p class="text-sm text-base-content/60 mt-1">{{ $car->make }} {{ $car->model }} &middot; {{ $car->year }}</p>
    </div>

    <div class="flex items-center gap-2 shrink-0">
        <x-ui.button href="{{ route('admin.cars.edit', $car) }}" variant="outline" size="sm">Edit</x-ui.button>

        <form method="POST" action="{{ route('admin.cars.destroy', $car) }}" onsubmit="return confirm('Delete {{ $car->title }}? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <x-ui.button type="submit" variant="error" size="sm">Delete</x-ui.button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Gallery bento grid --}}
        <x-ui.card>
            @php
                $slides = $gallery->isNotEmpty()
                    ? $gallery
                    : collect([(object) ['id' => 'cover', 'image_path' => $car->cover_image ?? 'https://placehold.co/1200x800?text=No+Image', 'alt_text' => $car->title]]);
                $slideCount = $slides->count();
                $visible = $slides->take(5);
                $remaining = $slideCount - $visible->count();
            @endphp

            <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[420px] rounded-box overflow-hidden">
                @foreach ($visible as $index => $image)
                    @php
                        // Tile 0 is the big hero tile (left half, both rows); tiles 1-4 fill the right side.
                        $tileClass = $index === 0 ? 'col-span-4 row-span-2 md:col-span-2' : 'col-span-2 md:col-span-1 row-span-1';
                        $isLastVisible = $index === $visible->count() - 1;
                    @endphp

                    <div class="relative {{ $tileClass }} group">
                        <img
                            src="{{ $image->image_path }}"
                            alt="{{ $image->alt_text ?? $car->title }}"
                            class="w-full h-full object-cover"
                            loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                        />

                        @if (!empty($image->is_cover))
                            <span class="absolute top-2 left-2 badge badge-primary badge-sm">Cover</span>
                        @endif

                        @if ($isLastVisible && $remaining > 0)
                            <button
                                type="button"
                                onclick="document.getElementById('gallery-modal-{{ $car->id }}').showModal()"
                                class="absolute inset-0 bg-neutral/60 hover:bg-neutral/70 transition-colors flex items-center justify-center text-neutral-content font-semibold text-lg"
                            >
                                +{{ $remaining }} more
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($slideCount > 1)
                <x-ui.button
                    variant="outline"
                    size="sm"
                    class="mt-4"
                    onclick="document.getElementById('gallery-modal-{{ $car->id }}').showModal()"
                >
                    View all {{ $slideCount }} photos
                </x-ui.button>
            @endif
        </x-ui.card>

        <x-ui.modal id="gallery-modal-{{ $car->id }}" title="{{ $car->title }}   Photos" size="xl">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[70vh] overflow-y-auto">
                @foreach ($slides as $image)
                    <div class="relative rounded-box overflow-hidden aspect-[4/3]">
                        <img
                            src="{{ $image->image_path }}"
                            alt="{{ $image->alt_text ?? $car->title }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                        />
                        @if (!empty($image->is_cover))
                            <span class="absolute top-2 left-2 badge badge-primary badge-sm">Cover</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <x-slot:actions>
                <form method="dialog"><x-ui.button variant="ghost">Close</x-ui.button></form>
            </x-slot:actions>
        </x-ui.modal>

        {{-- Description --}}
        <x-ui.card title="Description">
            @if ($car->description)
                <p class="text-sm text-base-content/70 whitespace-pre-line leading-relaxed">{{ $car->description }}</p>
            @else
                <p class="text-sm text-base-content/40 italic">No description added yet.</p>
            @endif
        </x-ui.card>

        {{-- Features --}}
        <x-ui.card title="Features">
            @if (!empty($car->features))
                <div class="flex flex-wrap gap-2">
                    @foreach ($car->features as $feature)
                        <x-ui.badge variant="ghost" outline>{{ $featureLabels[$feature] ?? ucfirst(str_replace('_', ' ', $feature)) }}</x-ui.badge>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-base-content/40 italic">No features listed.</p>
            @endif
        </x-ui.card>
    </div>

    <div class="space-y-6">
        {{-- Price + specs --}}
        <x-ui.card>
            <p class="text-2xl font-semibold text-primary font-display">
                {{ $car->currency }} {{ number_format($car->price) }}
                @if ($car->price_period !== 'total')
                    <span class="text-sm font-normal text-base-content/50">/ {{ $car->price_period }}</span>
                @endif
            </p>

            <div class="divider my-3"></div>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Body Type</dt>
                    <dd class="font-medium capitalize">{{ $car->body_type }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Condition</dt>
                    <dd class="font-medium">{{ $conditionLabels[$car->condition] ?? ucfirst($car->condition) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Mileage</dt>
                    <dd class="font-medium">{{ number_format($car->mileage) }} km</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Fuel Type</dt>
                    <dd class="font-medium capitalize">{{ $car->fuel_type }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Transmission</dt>
                    <dd class="font-medium capitalize">{{ $car->transmission }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Engine</dt>
                    <dd class="font-medium">{{ $car->engine_capacity ? number_format($car->engine_capacity, 1) . 'L' : ' ' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Seats / Doors</dt>
                    <dd class="font-medium">{{ $car->seats }} seats &middot; {{ $car->doors }} doors</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Color</dt>
                    <dd class="font-medium">{{ $car->color ?? ' ' }}</dd>
                </div>
            </dl>
        </x-ui.card>

        {{-- Meta --}}
        <x-ui.card title="Listing Info">
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Slug</dt>
                    <dd class="font-mono text-xs bg-base-200 px-2 py-0.5 rounded">{{ $car->slug }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">VIN</dt>
                    <dd class="font-mono text-xs bg-base-200 px-2 py-0.5 rounded">{{ $car->vin ?? ' ' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Owner</dt>
                    <dd class="font-medium">{{ $car->owner->name ?? 'Unassigned' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Views</dt>
                    <dd class="font-medium">{{ number_format($car->views_count) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-base-content/60">Last Updated</dt>
                    <dd class="font-medium">{{ $car->updated_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </x-ui.card>

        <x-ui.button href="{{ route('cars.show', $car->slug) }}" variant="ghost" class="w-full" target="_blank">
            View on Public Site &nearr;
        </x-ui.button>
    </div>
</div>
@endsection