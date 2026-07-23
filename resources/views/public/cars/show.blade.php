@extends('layouts.public')

@section('title', $car['title'] . ' | ME FOR YOU')

{{-- ===== OG / SEO OVERRIDES ===== --}}
@section('og_title', $car['title'] . ' | ME FOR YOU')
@section('og_description', Str::limit($car['description'] ?? 'Car rental details and availability.', 150))
@section('og_image', asset($car['image']))
@section('og_image_alt', $car['title'])
@section('og_image_width', '1200')
@section('og_image_height', '630')

@section('meta_description', Str::limit($car['description'] ?? 'Car rental details and availability.', 160))
@section('meta_keywords', 'ME FOR YOU, transport, ' . strtolower($car['type']) . ', car rental, ' . $car['make'] ?? (''
    . ' ' . $car['model'] ?? '' . ', Kigali, Rwanda'))

    {{-- ===== CONTENT ===== --}}
@section('content')
    <section class="pt-28 pb-16 px-6">
        <div class="max-w-[1200px] mx-auto">
            <a href="{{ route('cars.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Transport</a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-6">
                <div class="lg:col-span-2">
                    <div class="img-wrapper rounded-box h-[380px] mb-6">
                        <img src="{{ asset($car['image']) }}" alt="{{ $car['title'] }}">
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <x-ui.badge :variant="$car['status'] === 'available' ? 'success' : 'neutral'">{{ ucfirst($car['status']) }}</x-ui.badge>
                        <x-ui.badge variant="ghost" outline>{{ $car['type'] }}</x-ui.badge>
                    </div>

                    <h1 class="font-display text-4xl font-semibold">{{ $car['title'] }}</h1>

                    <div class="flex gap-8 mt-6 text-sm">
                        <div>
                            <p class="font-semibold text-lg">{{ $car['seats'] }}</p>
                            <p class="text-base-content/50">Seats</p>
                        </div>
                        <div>
                            <p class="font-semibold text-lg">{{ $car['transmission'] }}</p>
                            <p class="text-base-content/50">Transmission</p>
                        </div>
                        <div>
                            <p class="font-semibold text-lg">{{ $car['type'] }}</p>
                            <p class="text-base-content/50">Type</p>
                        </div>
                    </div>

                    <p class="section-body mt-6 max-w-none">
                        The {{ $car['title'] }} is available for self-drive or chauffeured rental through ME FOR YOU's
                        transport service, ideal for city travel, events, and airport transfers.
                    </p>
                </div>

                <div>
                    <x-ui.card class="sticky top-24">
                        <p class="text-2xl font-semibold text-primary font-display">{{ $car['price'] }}</p>
                        <x-ui.button href="{{ route('contact') }}" class="w-full mt-4">Book This Car</x-ui.button>
                        <x-ui.button href="{{ route('cars.index') }}" variant="outline" class="w-full mt-2">View More
                            Cars</x-ui.button>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </section>
@endsection
