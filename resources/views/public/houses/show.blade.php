@extends('layouts.public')

@section('title', $house['title'] . ' | ME FOR YOU')

{{-- ===== OG / SEO OVERRIDES ===== --}}
@section('og_title', $house['title'] . ' | ME FOR YOU')
@section('og_description', Str::limit($house['description'] ?? 'Property details and rental information.', 150))
@section('og_image', asset($house['image']))
@section('og_image_alt', $house['title'])
@section('og_image_width', '1200')
@section('og_image_height', '630')

@section('meta_description', Str::limit($house['description'] ?? 'Property details and rental information.', 160))
@section('meta_keywords', 'ME FOR YOU, housing, ' . strtolower($house['type']) . ', ' . $house['location'] . ', Kigali, Rwanda')

{{-- ===== CONTENT ===== --}}
@section('content')
<section class="pt-28 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <a href="{{ route('houses.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Housing</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-6">
            <div class="lg:col-span-2">
                <div class="img-wrapper rounded-box h-[380px] mb-6">
                    <img src="{{ asset($house['image']) }}" alt="{{ $house['title'] }}">
                </div>

                <div class="flex items-center gap-2 mb-2">
                    <x-ui.badge :variant="$house['status'] === 'available' ? 'success' : 'neutral'">{{ ucfirst($house['status']) }}</x-ui.badge>
                    <x-ui.badge variant="ghost" outline>{{ $house['type'] }}</x-ui.badge>
                </div>

                <h1 class="font-display text-4xl font-semibold">{{ $house['title'] }}</h1>
                <p class="text-base-content/60 mt-1">{{ $house['location'] }}</p>

                <div class="flex gap-8 mt-6 text-sm">
                    <div><p class="font-semibold text-lg">{{ $house['beds'] }}</p><p class="text-base-content/50">Bedrooms</p></div>
                    <div><p class="font-semibold text-lg">{{ $house['baths'] }}</p><p class="text-base-content/50">Bathrooms</p></div>
                    <div><p class="font-semibold text-lg">{{ $house['type'] }}</p><p class="text-base-content/50">Type</p></div>
                </div>

                <p class="section-body mt-6 max-w-none">
                    A well-maintained {{ strtolower($house['type']) }} located in {{ $house['location'] }}, offered through ME FOR YOU's managed housing portfolio. Contact our team to schedule a viewing or request more details on lease terms.
                </p>
            </div>

            <div>
                <x-ui.card class="sticky top-24">
                    <p class="text-2xl font-semibold text-primary font-display">{{ $house['price'] }}</p>
                    <x-ui.button href="{{ route('contact') }}" class="w-full mt-4">Request a Viewing</x-ui.button>
                    <x-ui.button href="{{ route('houses.index') }}" variant="outline" class="w-full mt-2">View More Houses</x-ui.button>
                </x-ui.card>
            </div>
        </div>
    </div>
</section>
@endsection