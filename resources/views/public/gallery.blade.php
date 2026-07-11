@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">Gallery</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Our work, in pictures</h1>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach (['housing/property-01.webp', 'housing/hero-house.webp', 'gallery/house-02.webp', 'transport/car-01.webp', 'transport/hero-car.webp', 'events/event-01.webp', 'gallery/corporate-01.webp', 'gallery/event-decor-01.webp'] as $img)
                <div class="img-wrapper rounded-box h-44 sm:h-52">
                    <img src="{{ asset('assets/' . $img) }}" alt="ME FOR YOU gallery" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
