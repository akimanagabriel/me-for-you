@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $featureLabels = [
        'catering' => 'Catering',
        'audio_visual' => 'Audio Visual',
        'parking' => 'Parking',
        'security' => 'Security',
        'wifi' => 'Wi-Fi',
        'photography' => 'Photography',
        'videography' => 'Videography',
        'decorations' => 'Decorations',
        'live_music' => 'Live Music',
        'dj' => 'DJ',
        'bar_service' => 'Bar Service',
        'tents' => 'Tents',
        'lighting' => 'Lighting',
        'stage' => 'Stage',
    ];
    $requirementLabels = [
        'dress_code' => 'Dress Code',
        'age_restriction' => 'Age Restriction',
        'registration_required' => 'Registration Required',
        'id_required' => 'ID Required',
        'invitation_only' => 'Invitation Only',
        'vaccination_required' => 'Vaccination Required',
    ];
    $selectedFeatures = old('features', []);
    $selectedRequirements = old('requirements', []);
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Events</a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Create a new event listing.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
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
                            placeholder="e.g. Kigali Tech Conference 2026"
                            required
                        />
                        @error('title')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="label"><span class="label-text">Category</span></label>
                            <select id="category" name="category" class="select select-bordered w-full @error('category') select-error @enderror" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="label"><span class="label-text">Status</span></label>
                            <select id="status" name="status" class="select select-bordered w-full @error('status') select-error @enderror" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(old('status', 'draft') === $status)>{{ ucfirst($status) }}</option>
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
                            placeholder="Describe the event in detail..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Date & Time --}}
            <x-ui.card title="Date & Time">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="event_date" class="label"><span class="label-text">Event Date</span></label>
                        <input
                            type="date"
                            id="event_date"
                            name="event_date"
                            value="{{ old('event_date') }}"
                            class="input input-bordered w-full @error('event_date') input-error @enderror"
                            required
                        />
                        @error('event_date')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_time" class="label"><span class="label-text">Start Time</span></label>
                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            class="input input-bordered w-full @error('start_time') input-error @enderror"
                        />
                        @error('start_time')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="label"><span class="label-text">End Time</span></label>
                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time') }}"
                            class="input input-bordered w-full @error('end_time') input-error @enderror"
                        />
                        @error('end_time')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Location --}}
            <x-ui.card title="Location">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="venue" class="label"><span class="label-text">Venue <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="venue"
                            name="venue"
                            value="{{ old('venue') }}"
                            class="input input-bordered w-full @error('venue') input-error @enderror"
                            placeholder="e.g. Kigali Convention Centre"
                        />
                        @error('venue')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="label"><span class="label-text">Neighborhood / Area</span></label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location') }}"
                            class="input input-bordered w-full @error('location') input-error @enderror"
                            placeholder="e.g. Kacyiru"
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
                            value="{{ old('city', 'Kigali') }}"
                            class="input input-bordered w-full @error('city') input-error @enderror"
                            required
                        />
                        @error('city')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="label"><span class="label-text">Address <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            value="{{ old('address') }}"
                            class="input input-bordered w-full @error('address') input-error @enderror"
                            placeholder="Street address"
                        />
                        @error('address')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Pricing --}}
            <x-ui.card title="Pricing">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="label"><span class="label-text">Price <span class="text-base-content/40">(leave empty for free)</span></span></label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="0.01"
                            value="{{ old('price') }}"
                            class="input input-bordered w-full @error('price') input-error @enderror"
                            placeholder="0.00"
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
                                <option value="{{ $period }}" @selected(old('price_period', 'total') === $period)>{{ ucwords(str_replace('_', ' ', $period)) }}</option>
                            @endforeach
                        </select>
                        @error('price_period')
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

            {{-- Requirements --}}
            <x-ui.card title="Requirements">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ($requirementsOptions as $requirement)
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input
                                type="checkbox"
                                name="requirements[]"
                                value="{{ $requirement }}"
                                class="checkbox checkbox-sm checkbox-primary"
                                @checked(in_array($requirement, $selectedRequirements))
                            />
                            <span>{{ $requirementLabels[$requirement] ?? ucfirst(str_replace('_', ' ', $requirement)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('requirements')
                    <p class="text-xs text-error mt-2">{{ $message }}</p>
                @enderror
                @error('requirements.*')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </x-ui.card>

            {{-- Speaker & Host --}}
            <x-ui.card title="Speaker & Host">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="speaker" class="label"><span class="label-text">Speaker <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="speaker"
                            name="speaker"
                            value="{{ old('speaker') }}"
                            class="input input-bordered w-full @error('speaker') input-error @enderror"
                            placeholder="e.g. John Doe"
                        />
                        @error('speaker')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="host" class="label"><span class="label-text">Host <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="host"
                            name="host"
                            value="{{ old('host') }}"
                            class="input input-bordered w-full @error('host') input-error @enderror"
                            placeholder="e.g. Jane Smith"
                        />
                        @error('host')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="organizer" class="label"><span class="label-text">Organizer <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="organizer"
                            name="organizer"
                            value="{{ old('organizer') }}"
                            class="input input-bordered w-full @error('organizer') input-error @enderror"
                            placeholder="Organization name"
                        />
                        @error('organizer')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Contact --}}
            <x-ui.card title="Contact Information">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_email" class="label"><span class="label-text">Contact Email <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="email"
                            id="contact_email"
                            name="contact_email"
                            value="{{ old('contact_email') }}"
                            class="input input-bordered w-full @error('contact_email') input-error @enderror"
                            placeholder="event@example.com"
                        />
                        @error('contact_email')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="label"><span class="label-text">Contact Phone <span class="text-base-content/40">(optional)</span></span></label>
                        <input
                            type="text"
                            id="contact_phone"
                            name="contact_phone"
                            value="{{ old('contact_phone') }}"
                            class="input input-bordered w-full @error('contact_phone') input-error @enderror"
                            placeholder="+250 788 123 456"
                        />
                        @error('contact_phone')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
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
                        <span class="text-sm font-medium">Featured Event</span>
                        <p class="text-xs text-base-content/50">Show this event in featured sections.</p>
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
                        <span class="text-base-content/60">Created</span>
                        <span class="font-medium">Just now</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Status</span>
                        <span class="badge badge-soft badge-ghost">Draft</span>
                    </div>
                </div>
            </x-ui.card>

            {{-- Actions --}}
            <x-ui.card>
                <div class="flex flex-col gap-2">
                    <x-ui.button type="submit" variant="primary" class="w-full">
                        <i class="fas fa-plus-circle mr-2"></i> Create Event
                    </x-ui.button>
                    <x-ui.button href="{{ route('admin.events.index') }}" variant="ghost" class="w-full">Cancel</x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
@endsection