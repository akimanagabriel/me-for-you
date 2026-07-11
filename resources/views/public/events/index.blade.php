@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">Events</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Unforgettable events, fully managed</h1>
        <p class="text-neutral-content/70 max-w-[540px] mt-3">From weddings to corporate conferences, our team handles every detail.</p>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($events as $event)
                <a href="{{ route('events.show', $event['slug']) }}" class="group block">
                    <div class="img-wrapper rounded-box h-56 mb-4">
                        <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}" loading="lazy">
                    </div>
                    <p class="section-label !mb-1">{{ $event['category'] }}</p>
                    <h3 class="font-display text-xl font-semibold group-hover:text-primary transition-colors">{{ $event['title'] }}</h3>
                    <p class="font-semibold text-primary mt-2">{{ $event['price'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
