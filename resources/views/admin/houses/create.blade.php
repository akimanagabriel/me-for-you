@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $amenityLabels = [
        'wifi' => 'Wi-Fi', 'parking' => 'Parking', 'pool' => 'Swimming Pool', 'gym' => 'Gym',
        'security' => '24/7 Security', 'generator' => 'Backup Generator', 'water_tank' => 'Water Tank',
        'garden' => 'Garden', 'balcony' => 'Balcony', 'air_conditioning' => 'Air Conditioning',
    ];
    $selectedAmenities = old('amenities', []);
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.houses.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Houses</a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Create a new property listing.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.houses.store') }}" enctype="multipart/form-data">
    @csrf

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
                            value="{{ old('title') }}"
                            class="input input-bordered w-full @error('title') input-error @enderror"
                            placeholder="e.g. Gisozi Suites 222"
                            required
                        />
                        @error('title')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="label"><span class="label-text">Type</span></label>
                            <select id="type" name="type" class="select select-bordered w-full @error('type') select-error @enderror" required>
                                <option value="" disabled selected>Select a type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(old('type') === $type)>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="label"><span class="label-text">Status</span></label>
                            <select id="status" name="status" class="select select-bordered w-full @error('status') select-error @enderror" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(old('status', 'available') === $status)>{{ ucfirst($status) }}</option>
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
                            placeholder="Describe the property..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Location --}}
            <x-ui.card title="Location">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="label"><span class="label-text">Neighborhood / Area</span></label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location') }}"
                            class="input input-bordered w-full @error('location') input-error @enderror"
                            required
                        />
                        @error('location')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="label"><span class="label-text">City</span></label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            value="{{ old('city') }}"
                            class="input input-bordered w-full @error('city') input-error @enderror"
                            required
                        />
                        @error('city')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="label"><span class="label-text">Address <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            value="{{ old('address') }}"
                            class="input input-bordered w-full @error('address') input-error @enderror"
                        />
                        @error('address')
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
                            value="{{ old('price') }}"
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
                            value="{{ old('currency', 'RWF') }}"
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
                                <option value="{{ $period }}" @selected(old('price_period') === $period)>{{ ucfirst($period) }}</option>
                            @endforeach
                        </select>
                        @error('price_period')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bedrooms" class="label"><span class="label-text">Bedrooms</span></label>
                        <input
                            type="number"
                            id="bedrooms"
                            name="bedrooms"
                            min="0"
                            max="255"
                            value="{{ old('bedrooms', 1) }}"
                            class="input input-bordered w-full @error('bedrooms') input-error @enderror"
                            required
                        />
                        @error('bedrooms')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bathrooms" class="label"><span class="label-text">Bathrooms</span></label>
                        <input
                            type="number"
                            id="bathrooms"
                            name="bathrooms"
                            min="0"
                            max="255"
                            value="{{ old('bathrooms', 1) }}"
                            class="input input-bordered w-full @error('bathrooms') input-error @enderror"
                            required
                        />
                        @error('bathrooms')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="size_sqm" class="label"><span class="label-text">Size (sqm)</span></label>
                        <input
                            type="number"
                            id="size_sqm"
                            name="size_sqm"
                            min="0"
                            value="{{ old('size_sqm') }}"
                            class="input input-bordered w-full @error('size_sqm') input-error @enderror"
                        />
                        @error('size_sqm')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Amenities --}}
            <x-ui.card title="Amenities">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($amenitiesOptions as $amenity)
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input
                                type="checkbox"
                                name="amenities[]"
                                value="{{ $amenity }}"
                                class="checkbox checkbox-sm checkbox-primary"
                                @checked(in_array($amenity, $selectedAmenities))
                            />
                            <span>{{ $amenityLabels[$amenity] ?? ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('amenities')
                    <p class="text-xs text-error mt-2">{{ $message }}</p>
                @enderror
            </x-ui.card>

            {{-- Images --}}
            <x-ui.card title="Photos">
                <div class="space-y-6">
                    <div>
                        <label class="label"><span class="label-text">Cover Image</span></label>
                        <input
                            type="file"
                            name="cover_image"
                            accept="image/*"
                            class="file-input file-input-bordered file-input-sm w-full @error('cover_image') file-input-error @enderror"
                        />
                        <p class="text-xs text-base-content/50 mt-1">This is the main image shown in listings.</p>
                        @error('cover_image')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="divider my-0"></div>

                    <div>
                        <label class="label"><span class="label-text">Gallery Images <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="file"
                            name="gallery[]"
                            accept="image/*"
                            multiple
                            class="file-input file-input-bordered file-input-sm w-full @error('gallery.*') file-input-error @enderror"
                        />
                        <p class="text-xs text-base-content/50 mt-1">You can select multiple files at once.</p>
                        @error('gallery.*')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            {{-- Visibility --}}
            <x-ui.card title="Visibility">
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <span class="text-sm font-medium">Featured Listing</span>
                        <p class="text-xs text-base-content/50">Show this house in featured sections.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        class="toggle toggle-primary"
                        @checked(old('is_featured'))
                    />
                </label>
            </x-ui.card>

            {{-- Actions --}}
            <x-ui.card>
                <div class="flex flex-col gap-2">
                    <x-ui.button type="submit" variant="primary" class="w-full">Create House</x-ui.button>
                    <x-ui.button href="{{ route('admin.houses.index') }}" variant="ghost" class="w-full">Cancel</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
@endsection