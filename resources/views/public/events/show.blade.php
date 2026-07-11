@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="pt-28 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <a href="{{ route('events.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Events</a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-6">
            <div class="lg:col-span-2">
                <div class="img-wrapper rounded-box h-[380px] mb-6">
                    <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}">
                </div>

                <p class="section-label">{{ $event['category'] }}</p>
                <h1 class="font-display text-4xl font-semibold">{{ $event['title'] }}</h1>

                <p class="section-body mt-6 max-w-none">
                    Our {{ strtolower($event['category']) }} package covers venue coordination, décor, catering liaison, transport, and full on-day management — tailored to your vision and budget.
                </p>
            </div>

            <div>
                <x-ui.card class="sticky top-24">
                    <p class="text-2xl font-semibold text-primary font-display">{{ $event['price'] }}</p>
                    <x-ui.button href="{{ route('contact') }}" class="w-full mt-4">Enquire About This Package</x-ui.button>
                    <x-ui.button href="{{ route('events.index') }}" variant="outline" class="w-full mt-2">View More Events</x-ui.button>
                </x-ui.card>
            </div>
        </div>
    </div>
</section>
@endsection
