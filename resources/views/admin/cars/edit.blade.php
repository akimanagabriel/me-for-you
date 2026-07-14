@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $statusVariants = [
        'available' => 'success',
        'reserved' => 'warning',
        'sold' => 'neutral',
        'unavailable' => 'error',
    ];
    $featureLabels = [
        'ac' => 'Air Conditioning', 'bluetooth' => 'Bluetooth', 'sunroof' => 'Sunroof',
        'backup_camera' => 'Backup Camera', 'leather_seats' => 'Leather Seats', 'navigation' => 'Navigation',
        'cruise_control' => 'Cruise Control', 'heated_seats' => 'Heated Seats', 'keyless_entry' => 'Keyless Entry',
        'parking_sensors' => 'Parking Sensors', 'alloy_wheels' => 'Alloy Wheels', 'third_row_seats' => 'Third Row Seats',
    ];
    $selectedFeatures = old('features', $car->features ?? []);
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.cars.show', $car) }}" class="text-sm text-primary hover:underline">&larr; Back to {{ $car->title }}</a>

        <div class="flex flex-wrap items-center gap-2 mt-2">
            <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
            <x-ui.badge :variant="$statusVariants[$car->status] ?? 'neutral'">{{ ucfirst($car->status) }}</x-ui.badge>
            @if ($car->is_featured)
                <x-ui.badge variant="accent">Featured</x-ui.badge>
            @endif
        </div>
        <p class="text-sm text-base-content/60 mt-1">Update vehicle details, pricing, and photos.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic info --}}
            <x-ui.card title="Basic Information">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="label"><span class="label-text">Title</span></label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $car->title) }}"
                            class="input input-bordered w-full @error('title') input-error @enderror"
                            required
                        />
                        @error('title')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="body_type" class="label"><span class="label-text">Body Type</span></label>
                            <select id="body_type" name="body_type" class="select select-bordered w-full @error('body_type') select-error @enderror" required>
                                @foreach ($bodyTypes as $bodyType)
                                    <option value="{{ $bodyType }}" @selected(old('body_type', $car->body_type) === $bodyType)>{{ ucfirst($bodyType) }}</option>
                                @endforeach
                            </select>
                            @error('body_type')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="label"><span class="label-text">Status</span></label>
                            <select id="status" name="status" class="select select-bordered w-full @error('status') select-error @enderror" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(old('status', $car->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="label"><span class="label-text">Description</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                            placeholder="Describe the vehicle..."
                        >{{ old('description', $car->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Vehicle details --}}
            <x-ui.card title="Vehicle Details">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="make" class="label"><span class="label-text">Make</span></label>
                        <input
                            type="text"
                            id="make"
                            name="make"
                            value="{{ old('make', $car->make) }}"
                            class="input input-bordered w-full @error('make') input-error @enderror"
                            required
                        />
                        @error('make')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="model" class="label"><span class="label-text">Model</span></label>
                        <input
                            type="text"
                            id="model"
                            name="model"
                            value="{{ old('model', $car->model) }}"
                            class="input input-bordered w-full @error('model') input-error @enderror"
                            required
                        />
                        @error('model')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="label"><span class="label-text">Year</span></label>
                        <input
                            type="number"
                            id="year"
                            name="year"
                            min="1900"
                            max="{{ now()->year + 1 }}"
                            value="{{ old('year', $car->year) }}"
                            class="input input-bordered w-full @error('year') input-error @enderror"
                            required
                        />
                        @error('year')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="label"><span class="label-text">Color <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="color"
                            name="color"
                            value="{{ old('color', $car->color) }}"
                            class="input input-bordered w-full @error('color') input-error @enderror"
                        />
                        @error('color')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vin" class="label"><span class="label-text">VIN <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="vin"
                            name="vin"
                            maxlength="32"
                            value="{{ old('vin', $car->vin) }}"
                            class="input input-bordered w-full uppercase @error('vin') input-error @enderror"
                        />
                        @error('vin')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="condition" class="label"><span class="label-text">Condition</span></label>
                        <select id="condition" name="condition" class="select select-bordered w-full @error('condition') select-error @enderror" required>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition }}" @selected(old('condition', $car->condition) === $condition)>{{ ucfirst(str_replace('_', ' ', $condition)) }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fuel_type" class="label"><span class="label-text">Fuel Type</span></label>
                        <select id="fuel_type" name="fuel_type" class="select select-bordered w-full @error('fuel_type') select-error @enderror" required>
                            @foreach ($fuelTypes as $fuelType)
                                <option value="{{ $fuelType }}" @selected(old('fuel_type', $car->fuel_type) === $fuelType)>{{ ucfirst($fuelType) }}</option>
                            @endforeach
                        </select>
                        @error('fuel_type')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="transmission" class="label"><span class="label-text">Transmission</span></label>
                        <select id="transmission" name="transmission" class="select select-bordered w-full @error('transmission') select-error @enderror" required>
                            @foreach ($transmissions as $transmission)
                                <option value="{{ $transmission }}" @selected(old('transmission', $car->transmission) === $transmission)>{{ ucfirst($transmission) }}</option>
                            @endforeach
                        </select>
                        @error('transmission')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Pricing & specs --}}
            <x-ui.card title="Pricing & Specifications">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="label"><span class="label-text">Price</span></label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="0.01"
                            value="{{ old('price', $car->price) }}"
                            class="input input-bordered w-full @error('price') input-error @enderror"
                            required
                        />
                        @error('price')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="currency" class="label"><span class="label-text">Currency</span></label>
                        <input
                            type="text"
                            id="currency"
                            name="currency"
                            maxlength="3"
                            value="{{ old('currency', $car->currency) }}"
                            class="input input-bordered w-full uppercase @error('currency') input-error @enderror"
                            placeholder="RWF"
                            required
                        />
                        @error('currency')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price_period" class="label"><span class="label-text">Per</span></label>
                        <select id="price_period" name="price_period" class="select select-bordered w-full @error('price_period') select-error @enderror" required>
                            @foreach ($pricePeriods as $period)
                                <option value="{{ $period }}" @selected(old('price_period', $car->price_period) === $period)>{{ ucfirst($period) }}</option>
                            @endforeach
                        </select>
                        @error('price_period')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mileage" class="label"><span class="label-text">Mileage (km)</span></label>
                        <input
                            type="number"
                            id="mileage"
                            name="mileage"
                            min="0"
                            value="{{ old('mileage', $car->mileage) }}"
                            class="input input-bordered w-full @error('mileage') input-error @enderror"
                            required
                        />
                        @error('mileage')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="engine_capacity" class="label"><span class="label-text">Engine (L) <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="number"
                            id="engine_capacity"
                            name="engine_capacity"
                            min="0"
                            max="99.9"
                            step="0.1"
                            value="{{ old('engine_capacity', $car->engine_capacity) }}"
                            class="input input-bordered w-full @error('engine_capacity') input-error @enderror"
                        />
                        @error('engine_capacity')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="seats" class="label"><span class="label-text">Seats</span></label>
                        <input
                            type="number"
                            id="seats"
                            name="seats"
                            min="1"
                            max="50"
                            value="{{ old('seats', $car->seats) }}"
                            class="input input-bordered w-full @error('seats') input-error @enderror"
                            required
                        />
                        @error('seats')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="doors" class="label"><span class="label-text">Doors</span></label>
                        <input
                            type="number"
                            id="doors"
                            name="doors"
                            min="1"
                            max="10"
                            value="{{ old('doors', $car->doors) }}"
                            class="input input-bordered w-full @error('doors') input-error @enderror"
                            required
                        />
                        @error('doors')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Features --}}
            <x-ui.card title="Features">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($featuresOptions as $feature)
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input
                                type="checkbox"
                                name="features[]"
                                value="{{ $feature }}"
                                class="checkbox checkbox-sm checkbox-primary"
                                @checked(in_array($feature, $selectedFeatures))
                            />
                            <span>{{ $featureLabels[$feature] ?? ucfirst(str_replace('_', ' ', $feature)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('features')
                    <p class="text-xs text-error mt-2">{{ $message }}</p>
                @enderror
            </x-ui.card>

            {{-- Images --}}
            <x-ui.card title="Photos">
                <div class="space-y-6">
                    <div>
                        <label class="label"><span class="label-text">Cover Image</span></label>
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="w-20 h-20 rounded-box">
                                    <img
                                        src="{{ $car->cover_image ?? 'https://placehold.co/200x200?text=No+Cover' }}"
                                        alt="{{ $car->title }}"
                                    />
                                </div>
                            </div>
                            <div class="flex-1">
                                <input
                                    type="file"
                                    name="cover_image"
                                    accept="image/*"
                                    class="file-input file-input-bordered file-input-sm w-full @error('cover_image') file-input-error @enderror"
                                />
                                <p class="text-xs text-base-content/50 mt-1">Leave empty to keep the current cover image.</p>
                                @error('cover_image')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="divider my-0"></div>

                    <div>
                        <label class="label"><span class="label-text">Add Gallery Images</span></label>
                        <input
                            type="file"
                            name="gallery[]"
                            accept="image/*"
                            multiple
                            class="file-input file-input-bordered file-input-sm w-full @error('gallery.*') file-input-error @enderror"
                        />
                        <p class="text-xs text-base-content/50 mt-1">You can select multiple files. They'll be added to the existing gallery.</p>
                        @error('gallery.*')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($car->images->isNotEmpty())
                        <div class="divider my-0"></div>

                        <div>
                            <label class="label"><span class="label-text">Current Gallery</span></label>
                            <p class="text-xs text-base-content/50 mb-3">Check any photos you'd like to remove, then save changes.</p>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($car->images as $image)
                                    @php $removeId = 'remove-image-' . $image->id; @endphp

                                    <div class="relative rounded-box overflow-hidden aspect-[4/3] group">
                                        <input
                                            type="checkbox"
                                            name="remove_images[]"
                                            value="{{ $image->id }}"
                                            id="{{ $removeId }}"
                                            class="peer sr-only"
                                        />

                                        <img
                                            src="{{ $image->image_path }}"
                                            alt="{{ $image->alt_text ?? $car->title }}"
                                            class="w-full h-full object-cover transition-all duration-200 group-has-[:checked]:opacity-30 group-has-[:checked]:grayscale"
                                            loading="lazy"
                                        />

                                        @if ($image->is_cover)
                                            <span class="absolute top-2 left-2 badge badge-primary badge-sm">Cover</span>
                                        @endif

                                        <label
                                            for="{{ $removeId }}"
                                            title="Mark for removal"
                                            class="absolute top-2 right-2 flex items-center justify-center w-7 h-7 rounded-full bg-base-100/90 text-base-content/70 shadow-sm cursor-pointer transition-colors hover:bg-error hover:text-error-content peer-checked:bg-error peer-checked:text-error-content"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" clip-rule="evenodd" />
                                            </svg>
                                        </label>

                                        <div class="absolute inset-x-0 bottom-0 hidden group-has-[:checked]:flex items-center justify-center py-1.5 bg-error/90 text-error-content text-xs font-medium">
                                            Will be removed
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            {{-- Visibility --}}
            <x-ui.card title="Visibility">
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <span class="text-sm font-medium">Featured Listing</span>
                        <p class="text-xs text-base-content/50">Show this car in featured sections.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        class="toggle toggle-primary"
                        @checked(old('is_featured', $car->is_featured))
                    />
                </label>
            </x-ui.card>

            {{-- Listing info --}}
            <x-ui.card title="Listing Info">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Slug</dt>
                        <dd class="font-mono text-xs bg-base-200 px-2 py-0.5 rounded">{{ $car->slug }}</dd>
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

            {{-- Actions --}}
            <x-ui.card>
                <div class="flex flex-col gap-2">
                    <x-ui.button type="submit" variant="primary" class="w-full">Save Changes</x-ui.button>
                    <x-ui.button href="{{ route('admin.cars.show', $car) }}" variant="ghost" class="w-full">Cancel</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
@endsection
