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
                Housing <br /><span class="text-[#d49d6a]">Services</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed mb-8">
                Find your perfect home or investment property in Kigali. We handle listings, viewings, 
                negotiations, and paperwork so you move in with confidence.
            </p>
            <div class="flex flex-wrap gap-8">
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['total']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Total Properties</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['available']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Available</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['rented']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Rented</p>
                </div>
                <div>
                    <span class="font-display text-3xl font-semibold text-[#d49d6a]">{{ number_format($stats['cities']) }}</span>
                    <p class="text-sm text-white/40 mt-1">Cities</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Properties -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Featured</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Featured Properties</h2>
            </div>
        </div>

        @if($featuredHouses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredHouses as $house)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-[#ede7d8] hover:border-[#b87f3a]">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $house->cover_image ?? asset('assets/housing/property-placeholder.jpg') }}" alt="{{ $house->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 left-3 bg-[#b87f3a] text-white text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($house->type) }}</span>
                            @if($house->status === 'available')
                                <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Available</span>
                            @elseif($house->status === 'rented')
                                <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Rented</span>
                            @else
                                <span class="absolute top-3 right-3 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">{{ ucfirst($house->status) }}</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">{{ $house->title }}</h3>
                            <div class="space-y-1.5 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a] w-5"></i> 
                                    {{ $house->location }}, {{ $house->city }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-bed text-[#b87f3a] w-5"></i> 
                                    {{ $house->bedrooms }} Bedrooms
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-bath text-[#b87f3a] w-5"></i> 
                                    {{ $house->bathrooms }} Bathrooms
                                </p>
                                @if($house->size_sqm)
                                    <p class="flex items-center gap-2">
                                        <i class="fas fa-ruler-combined text-[#b87f3a] w-5"></i> 
                                        {{ $house->size_sqm }} sqm
                                    </p>
                                @endif
                                <p class="flex items-center gap-2 font-semibold text-[#b87f3a]">
                                    <i class="fas fa-tag text-[#b87f3a] w-5"></i> 
                                    {{ number_format($house->price, 0, ',', ',') }} {{ $house->currency }}/{{ $house->price_period }}
                                </p>
                            </div>
                            <a href="{{ route('services.house.show', $house->slug) }}" class="mt-4 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline group-hover:gap-3 transition-all">
                                View Property <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-[#f5f0e8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-3xl text-[#b87f3a]/40"></i>
                </div>
                <p class="text-[#7a7268]">No featured properties available.</p>
            </div>
        @endif
    </div>
</section>

<!-- Available Properties -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Available Now</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Available Properties</h2>
            </div>
            <a href="{{ route('contact') }}" class="text-[#b87f3a] font-semibold hover:underline inline-flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($availableHouses->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availableHouses as $house)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-[#ede7d8]">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $house->cover_image ?? asset('assets/housing/property-placeholder.jpg') }}" alt="{{ $house->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($house->type) }}</span>
                            <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Available</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-2">{{ $house->title }}</h3>
                            <div class="space-y-1 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a] w-4"></i> 
                                    {{ $house->location }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-bed text-[#b87f3a] w-4"></i> 
                                    {{ $house->bedrooms }} Beds 
                                    <i class="fas fa-bath text-[#b87f3a] w-4 ml-2"></i> 
                                    {{ $house->bathrooms }} Baths
                                </p>
                                <p class="font-semibold text-[#b87f3a]">
                                    {{ number_format($house->price, 0, ',', ',') }} {{ $house->currency }}/{{ $house->price_period }}
                                </p>
                            </div>
                            <a href="{{ route('services.house.show', $house->slug) }}" class="mt-3 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline text-sm group-hover:gap-3 transition-all">
                                View Property <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($availableHouses->hasPages())
                <div class="mt-8">
                    {{ $availableHouses->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-3xl text-[#b87f3a]/40"></i>
                </div>
                <p class="text-[#7a7268]">No available properties at the moment.</p>
            </div>
        @endif
    </div>
</section>

<!-- Rented Properties -->
@if($rentedHouses->isNotEmpty())
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <p class="text-[#7a7268] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Recently Rented</p>
                    <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Recently Rented Properties</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rentedHouses as $house)
                    <div class="group bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300 opacity-75">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $house->cover_image ?? asset('assets/housing/property-placeholder.jpg') }}" alt="{{ $house->title }}" class="w-full h-full object-cover">
                            <span class="absolute bottom-3 right-3 bg-[#1a1714]/70 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">{{ ucfirst($house->type) }}</span>
                            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">Rented</span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-2">{{ $house->title }}</h3>
                            <div class="space-y-1 text-sm text-[#7a7268]">
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-[#7a7268] w-4"></i> 
                                    {{ $house->location }}
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fas fa-bed text-[#7a7268] w-4"></i> 
                                    {{ $house->bedrooms }} Beds 
                                    <i class="fas fa-bath text-[#7a7268] w-4 ml-2"></i> 
                                    {{ $house->bathrooms }} Baths
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Why Choose Us -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Why Choose Us</p>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Your Trusted Housing Partner</h2>
            <p class="text-[#7a7268] mt-4 max-w-2xl mx-auto leading-relaxed">
                We make finding your perfect home simple, transparent, and stress-free.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="text-center p-6 bg-white rounded-xl hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">Wide Selection</h3>
                <p class="text-[#7a7268] leading-relaxed">Access to a diverse range of properties across Kigali and beyond.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-xl hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">Transparent Process</h3>
                <p class="text-[#7a7268] leading-relaxed">Clear communication and honest guidance throughout your property journey.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-xl hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">Trusted Service</h3>
                <p class="text-[#7a7268] leading-relaxed">Professional, reliable, and committed to finding you the perfect home.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-[#b87f3a]">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="font-display text-3xl md:text-4xl font-semibold mb-4">Ready to Find Your Perfect Home?</h2>
        <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto leading-relaxed">
            Let us help you find the property that meets all your needs. Contact us today to get started.
        </p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-[#8a6e22] font-semibold px-8 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
            <i class="fas fa-paper-plane"></i> Get in Touch
        </a>
    </div>
</section>
@endsection