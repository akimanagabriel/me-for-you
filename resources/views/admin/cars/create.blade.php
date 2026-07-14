@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $featureLabels = [
        'ac' => 'Air Conditioning',
        'bluetooth' => 'Bluetooth',
        'sunroof' => 'Sunroof',
        'backup_camera' => 'Backup Camera',
        'leather_seats' => 'Leather Seats',
        'navigation' => 'Navigation System',
        'cruise_control' => 'Cruise Control',
        'heated_seats' => 'Heated Seats',
        'keyless_entry' => 'Keyless Entry',
        'parking_sensors' => 'Parking Sensors',
        'alloy_wheels' => 'Alloy Wheels',
        'third_row_seats' => 'Third Row Seats',
    ];
    $selectedFeatures = old('features', []);
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.cars.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Cars</a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Add a new vehicle to your inventory.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
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
                            placeholder="e.g. 2023 Toyota RAV4 Limited"
                            required
                        />
                        @error('title')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="label"><span class="label-text">Description</span></label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                            placeholder="Describe the vehicle in detail..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Vehicle identity --}}
            <x-ui.card title="Vehicle Identity">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="make" class="label"><span class="label-text">Make</span></label>
                        <input
                            type="text"
                            id="make"
                            name="make"
                            value="{{ old('make') }}"
                            class="input input-bordered w-full @error('make') input-error @enderror"
                            placeholder="e.g. Toyota"
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
                            value="{{ old('model') }}"
                            class="input input-bordered w-full @error('model') input-error @enderror"
                            placeholder="e.g. RAV4"
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
                            max="{{ date('Y') + 1 }}"
                            value="{{ old('year') }}"
                            class="input input-bordered w-full @error('year') input-error @enderror"
                            placeholder="e.g. 2023"
                            required
                        />
                        @error('year')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="label"><span class="label-text">Color</span></label>
                        <input
                            type="text"
                            id="color"
                            name="color"
                            value="{{ old('color') }}"
                            class="input input-bordered w-full @error('color') input-error @enderror"
                            placeholder="e.g. Silver, Black, Blue"
                        />
                        @error('color')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="vin" class="label"><span class="label-text">VIN <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="vin"
                            name="vin"
                            maxlength="32"
                            value="{{ old('vin') }}"
                            class="input input-bordered w-full @error('vin') input-error @enderror"
                            placeholder="Vehicle Identification Number"
                        />
                        @error('vin')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Classification --}}
            <x-ui.card title="Classification">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="body_type" class="label"><span class="label-text">Body Type</span></label>
                        <select id="body_type" name="body_type" class="select select-bordered w-full @error('body_type') select-error @enderror" required>
                            <option value="" disabled selected>Select body type</option>
                            @foreach ($bodyTypes as $type)
                                <option value="{{ $type }}" @selected(old('body_type') === $type)>{{ ucfirst($type) }}</option>
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
                                <option value="{{ $status }}" @selected(old('status', 'available') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="condition" class="label"><span class="label-text">Condition</span></label>
                        <select id="condition" name="condition" class="select select-bordered w-full @error('condition') select-error @enderror" required>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition }}" @selected(old('condition') === $condition)>{{ ucwords(str_replace('_', ' ', $condition)) }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fuel_type" class="label"><span class="label-text">Fuel Type</span></label>
                        <select id="fuel_type" name="fuel_type" class="select select-bordered w-full @error('fuel_type') select-error @enderror" required>
                            @foreach ($fuelTypes as $fuel)
                                <option value="{{ $fuel }}" @selected(old('fuel_type') === $fuel)>{{ ucfirst($fuel) }}</option>
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
                                <option value="{{ $transmission }}" @selected(old('transmission') === $transmission)>{{ ucfirst($transmission) }}</option>
                            @endforeach
                        </select>
                        @error('transmission')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Pricing --}}
            <x-ui.card title="Pricing">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
                        <label for="price_period" class="label"><span class="label-text">Price Period</span></label>
                        <select id="price_period" name="price_period" class="select select-bordered w-full @error('price_period') select-error @enderror" required>
                            @foreach ($pricePeriods as $period)
                                <option value="{{ $period }}" @selected(old('price_period') === $period)>{{ ucfirst($period) }}</option>
                            @endforeach
                        </select>
                        @error('price_period')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Specs --}}
            <x-ui.card title="Specifications">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="mileage" class="label"><span class="label-text">Mileage (km)</span></label>
                        <input
                            type="number"
                            id="mileage"
                            name="mileage"
                            min="0"
                            value="{{ old('mileage', 0) }}"
                            class="input input-bordered w-full @error('mileage') input-error @enderror"
                            required
                        />
                        @error('mileage')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="engine_capacity" class="label"><span class="label-text">Engine (L)</span></label>
                        <input
                            type="number"
                            id="engine_capacity"
                            name="engine_capacity"
                            min="0"
                            max="99.9"
                            step="0.1"
                            value="{{ old('engine_capacity') }}"
                            class="input input-bordered w-full @error('engine_capacity') input-error @enderror"
                            placeholder="e.g. 2.5"
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
                            value="{{ old('seats', 5) }}"
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
                            value="{{ old('doors', 4) }}"
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
                @error('features.*')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
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
                        <p class="text-xs text-base-content/50">Show this car in featured sections.</p>
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

            {{-- Quick Stats --}}
            <x-ui.card title="Quick Stats">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Views</span>
                        <span class="font-medium">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Listed</span>
                        <span class="font-medium">Just now</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Status</span>
                        <span class="badge badge-soft badge-success">Draft</span>
                    </div>
                </div>
            </x-ui.card>

            {{-- Actions --}}
            <x-ui.card>
                <div class="flex flex-col gap-2">
                    <x-ui.button type="submit" variant="primary" class="w-full">
                        <i class="fas fa-plus-circle mr-2"></i> Add Car
                    </x-ui.button>
                    <x-ui.button href="{{ route('admin.cars.index') }}" variant="ghost" class="w-full">Cancel</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
@endsection