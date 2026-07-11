@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">About Us</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold max-w-2xl">Your professional companion, every step of the way</h1>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[900px] mx-auto text-center">
        <p class="section-body mx-auto max-w-none">
            ME FOR YOU ADVISORY Ltd is a Kigali-based company offering trusted housing, transport, and event
            management services. We help individuals and businesses move through life's biggest milestones —
            from finding a home, to getting around the city, to celebrating unforgettable events — with confidence
            and care.
        </p>
    </div>
</section>

<section class="py-16 px-6 bg-base-200">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
        <div>
            <p class="font-display text-4xl font-semibold text-primary">50+</p>
            <p class="text-sm text-base-content/60 mt-1">Properties Managed</p>
        </div>
        <div>
            <p class="font-display text-4xl font-semibold text-primary">24+</p>
            <p class="text-sm text-base-content/60 mt-1">Vehicles in Fleet</p>
        </div>
        <div>
            <p class="font-display text-4xl font-semibold text-primary">100+</p>
            <p class="text-sm text-base-content/60 mt-1">Events Delivered</p>
        </div>
    </div>
</section>
@endsection
