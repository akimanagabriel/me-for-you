@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $statusVariants = [
        'available' => 'success',
        'rented' => 'info',
        'unavailable' => 'error',
    ];
    $amenityLabels = [
        'wifi' => 'Wi-Fi', 'parking' => 'Parking', 'pool' => 'Swimming Pool', 'gym' => 'Gym',
        'security' => '24/7 Security', 'generator' => 'Backup Generator', 'water_tank' => 'Water Tank',
        'garden' => 'Garden', 'balcony' => 'Balcony', 'air_conditioning' => 'Air Conditioning',
    ];
    $selectedAmenities = old('amenities', $house->amenities ?? []);
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.houses.show', $house) }}" class="text-sm text-primary hover:underline">&larr; Back to {{ $house->title }}</a>

        <div class="flex flex-wrap items-center gap-2 mt-2">
            <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
            <x-ui.badge :variant="$statusVariants[$house->status] ?? 'neutral'">{{ ucfirst($house->status) }}</x-ui.badge>
            @if ($house->is_featured)
                <x-ui.badge variant="accent">Featured</x-ui.badge>
            @endif
        </div>
        <p class="text-sm text-base-content/60 mt-1">Update listing details, pricing, and photos.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.houses.update', $house) }}" enctype="multipart/form-data">
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
                            value="{{ old('title', $house->title) }}"
                            class="input input-bordered w-full @error('title') input-error @enderror"
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
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @selected(old('type', $house->type) === $type)>{{ ucfirst($type) }}</option>
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
                                    <option value="{{ $status }}" @selected(old('status', $house->status) === $status)>{{ ucfirst($status) }}</option>
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
                        >{{ old('description', $house->description) }}</textarea>
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
                            value="{{ old('location', $house->location) }}"
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
                            value="{{ old('city', $house->city) }}"
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
                            value="{{ old('address', $house->address) }}"
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
                            value="{{ old('price', $house->price) }}"
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
                            value="{{ old('currency', $house->currency) }}"
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
                                <option value="{{ $period }}" @selected(old('price_period', $house->price_period) === $period)>{{ ucfirst($period) }}</option>
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
                            value="{{ old('bedrooms', $house->bedrooms) }}"
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
                            value="{{ old('bathrooms', $house->bathrooms) }}"
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
                            value="{{ old('size_sqm', $house->size_sqm) }}"
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
                        <div class="flex items-center gap-4">
                            <div class="avatar">
                                <div class="w-20 h-20 rounded-box">
                                    <img
                                        src="{{ $house->cover_image ?? 'https://placehold.co/200x200?text=No+Cover' }}"
                                        alt="{{ $house->title }}"
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

                    @if ($house->images->isNotEmpty())
                        <div class="divider my-0"></div>

                        <div>
                            <label class="label"><span class="label-text">Current Gallery</span></label>
                            <p class="text-xs text-base-content/50 mb-3">Check any photos you'd like to remove, then save changes.</p>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($house->images as $image)
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
                                            alt="{{ $image->alt_text ?? $house->title }}"
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
                        <p class="text-xs text-base-content/50">Show this house in featured sections.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        class="toggle toggle-primary"
                        @checked(old('is_featured', $house->is_featured))
                    />
                </label>
            </x-ui.card>

            {{-- Listing info --}}
            <x-ui.card title="Listing Info">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Slug</dt>
                        <dd class="font-mono text-xs bg-base-200 px-2 py-0.5 rounded">{{ $house->slug }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Owner</dt>
                        <dd class="font-medium">{{ $house->owner->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Views</dt>
                        <dd class="font-medium">{{ number_format($house->views_count) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Published</dt>
                        <dd class="font-medium">{{ $house->published_at?->format('M j, Y') ?? ' ' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Last Updated</dt>
                        <dd class="font-medium">{{ $house->updated_at->format('M j, Y') }}</dd>
                    </div>
                </dl>
            </x-ui.card>

            {{-- Actions --}}
            <x-ui.card>
                <div class="flex flex-col gap-2">
                    <x-ui.button type="submit" variant="primary" class="w-full">Save Changes</x-ui.button>
                    <x-ui.button href="{{ route('admin.houses.show', $house) }}" variant="ghost" class="w-full">Cancel</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
@endsection