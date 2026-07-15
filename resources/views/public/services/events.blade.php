@extends('layouts.public')

@section('title', $pageTitle)

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#1a1714] text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Our Services</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-6">
                Event Management <br /><span class="text-[#d49d6a]">Services</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed mb-8">
                From intimate gatherings to large corporate events, we handle every detail so you can enjoy the moment.
            </p>
            <div class="flex flex-wrap gap-8">
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['total']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Total Events</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['upcoming']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Upcoming</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['completed']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Completed</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['categories']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Categories</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Featured</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Featured Events</h2>
            </div>
        </div>

        @if($featuredEvents->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredEvents as $event)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#ede7d8] hover:border-[#b87f3a]">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $event->cover_image ?? asset('assets/events/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 bg-[#b87f3a] text-white text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($event->category) }}</span>
                        </div>
                        <div class="p-6">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">{{ $event->title }}</h3>
                            <div class="space-y-1.5 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-calendar-day text-[#b87f3a] w-5"></i> 
                                    {{ $event->event_date->format('M d, Y') }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a] w-5"></i> 
                                    {{ $event->location }}, {{ $event->city }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-tag text-[#b87f3a] w-5"></i> 
                                    @if($event->price)
                                        {{ number_format($event->price, 0, ',', ',') }} {{ $event->currency }}
                                    @else
                                        Free Event
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('services.event.show', $event->slug) }}" class="mt-4 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline group-hover:gap-3 transition-all">
                                Learn More <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-[#f5f0e8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-3xl text-[#b87f3a]/40"></i>
                </div>
                <p class="text-[#7a7268]">No featured events available.</p>
            </div>
        @endif
    </div>
</section>

<!-- Upcoming Events -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Upcoming</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Upcoming Events</h2>
            </div>
        </div>

        @if($upcomingEvents->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $event)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-[#ede7d8]">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $event->cover_image ?? asset('assets/events/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($event->category) }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-2">{{ $event->title }}</h3>
                            <div class="space-y-1 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-calendar-day text-[#b87f3a] w-4"></i> 
                                    {{ $event->event_date->format('M d, Y') }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a] w-4"></i> 
                                    {{ $event->location }}
                                </p>
                            </div>
                            <a href="{{ route('services.event.show', $event->slug) }}" class="mt-3 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline text-sm group-hover:gap-3 transition-all">
                                Learn More <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($upcomingEvents->hasPages())
                <div class="mt-8">
                    {{ $upcomingEvents->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-plus text-3xl text-[#b87f3a]/40"></i>
                </div>
                <p class="text-[#7a7268]">No upcoming events available.</p>
            </div>
        @endif
    </div>
</section>

<!-- Past Events -->
@if($pastEvents->isNotEmpty())
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Past Events</p>
                    <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Past Events</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pastEvents as $event)
                    <div class="group bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $event->cover_image ?? asset('assets/events/event-placeholder.jpg') }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">Completed</span>
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($event->category) }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-2">{{ $event->title }}</h3>
                            <div class="space-y-1 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-calendar-day text-[#b87f3a] w-4"></i> 
                                    {{ $event->event_date->format('M d, Y') }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a] w-4"></i> 
                                    {{ $event->location }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-tag text-[#b87f3a] w-4"></i> 
                                    @if($event->price)
                                        {{ number_format($event->price, 0, ',', ',') }} {{ $event->currency }}
                                    @else
                                        Free Event
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('services.event.show', $event->slug) }}" class="mt-3 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline text-sm group-hover:gap-3 transition-all">
                                View Details <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($pastEvents->count() >= 6)
                <div class="text-center mt-8">
                    <a href="{{ route('services.events') }}" class="inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline">
                        View All Past Events <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-[#b87f3a]">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="font-display text-3xl md:text-4xl font-semibold mb-4">Ready to Plan Your Event?</h2>
        <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto leading-relaxed">
            Let us help you create an unforgettable experience. Contact us today to get started.
        </p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-[#8a6e22] font-semibold px-8 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
            <i class="fas fa-paper-plane"></i> Get in Touch
        </a>
    </div>
</section>
@endsection