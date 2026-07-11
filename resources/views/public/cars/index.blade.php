@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">Transport</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Reliable rides, anywhere in Rwanda</h1>
        <p class="text-neutral-content/70 max-w-[540px] mt-3">A fleet of well-maintained vehicles with optional chauffeur service.</p>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($cars as $car)
                <a href="{{ route('cars.show', $car['slug']) }}" class="group block">
                    <div class="img-wrapper rounded-box h-56 mb-4">
                        <img src="{{ asset($car['image']) }}" alt="{{ $car['title'] }}" loading="lazy">
                        <span class="absolute top-3 right-3 badge {{ $car['status'] === 'available' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($car['status']) }}</span>
                    </div>
                    <h3 class="font-display text-xl font-semibold group-hover:text-primary transition-colors">{{ $car['title'] }}</h3>
                    <p class="text-sm text-base-content/60">{{ $car['type'] }} &middot; {{ $car['transmission'] }} &middot; {{ $car['seats'] }} seats</p>
                    <p class="font-semibold text-primary mt-2">{{ $car['price'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
