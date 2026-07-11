@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">Housing</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Find your next home in Kigali</h1>
        <p class="text-neutral-content/70 max-w-[540px] mt-3">Curated apartments, villas, and townhouses — vetted and managed by ME FOR YOU.</p>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($houses as $house)
                <a href="{{ route('houses.show', $house['slug']) }}" class="group block">
                    <div class="img-wrapper rounded-box h-56 mb-4">
                        <img src="{{ asset($house['image']) }}" alt="{{ $house['title'] }}" loading="lazy">
                        <span class="absolute top-3 right-3 badge {{ $house['status'] === 'available' ? 'badge-success' : 'badge-neutral' }}">{{ ucfirst($house['status']) }}</span>
                    </div>
                    <h3 class="font-display text-xl font-semibold group-hover:text-primary transition-colors">{{ $house['title'] }}</h3>
                    <p class="text-sm text-base-content/60">{{ $house['location'] }} &middot; {{ $house['type'] }}</p>
                    <div class="flex items-center justify-between mt-2 text-sm">
                        <span class="text-base-content/60">{{ $house['beds'] }} bd &middot; {{ $house['baths'] }} ba</span>
                        <span class="font-semibold text-primary">{{ $house['price'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
