@extends('layouts.public')

@section('title', $pageTitle)

@section('content')
<!-- Breadcrumb -->
<section class="bg-[#f5f0e8] py-4 border-b border-[#ede7d8]">
    <div class="container mx-auto px-4">
        <nav class="text-sm text-[#7a7268]">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-[#b87f3a] transition-colors">Home</a></li>
                <li><i class="fas fa-chevron-right text-xs text-[#7a7268]/40"></i></li>
                <li><a href="{{ route('services.housing') }}" class="hover:text-[#b87f3a] transition-colors">Housing</a></li>
                <li><i class="fas fa-chevron-right text-xs text-[#7a7268]/40"></i></li>
                <li class="text-[#1a1714] font-medium truncate">{{ $house->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- House Detail -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Cover Image -->
                <div class="rounded-xl overflow-hidden mb-6 bg-[#f5f0e8] relative">
                    @if($house->cover_image)
                        <img src="{{ $house->cover_image }}" alt="{{ $house->title }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 flex items-center justify-center bg-[#f5f0e8]">
                            <i class="fas fa-home text-6xl text-[#b87f3a]/30"></i>
                        </div>
                    @endif
                    @if($house->is_featured)
                        <span class="absolute top-4 left-4 bg-[#b87f3a] text-white text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                    @endif
                    @if($house->status === 'available')
                        <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Available
                        </span>
                    @elseif($house->status === 'rented')
                        <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-times-circle mr-1"></i> Rented
                        </span>
                    @else
                        <span class="absolute top-4 right-4 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">
                            {{ ucfirst($house->status) }}
                        </span>
                    @endif
                </div>

                <!-- Title & Basic Info -->
                <div class="mb-6">
                    <h1 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-3">{{ $house->title }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-[#7a7268]">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-tag text-[#b87f3a]"></i>
                            {{ ucfirst($house->type) }}
                        </span>
                        <span class="text-[#ede7d8]">|</span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-[#b87f3a]"></i>
                            {{ $house->location }}, {{ $house->city }}
                        </span>
                        <span class="text-[#ede7d8]">|</span>
                        <span class="flex items-center gap-1">
                            <i class="far fa-eye text-[#7a7268]/40"></i>
                            {{ number_format($house->views_count) }} views
                        </span>
                    </div>
                </div>

                <!-- Price Highlight -->
                <div class="bg-[#f5f0e8] border border-[#ede7d8] rounded-xl p-5 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[#7a7268]">Price</p>
                            <p class="font-display text-3xl font-semibold text-[#b87f3a]">
                                {{ number_format($house->price, 0, ',', ',') }} {{ $house->currency }}
                                <span class="text-sm font-normal text-[#7a7268]">/ {{ $house->price_period }}</span>
                            </p>
                        </div>
                        @if($house->status === 'available')
                            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-[#b87f3a] text-white px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors font-semibold">
                                <i class="fas fa-phone"></i> Inquire Now
                            </a>
                        @else
                            <span class="inline-flex items-center gap-2 bg-[#ede7d8] text-[#7a7268] px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                <i class="fas fa-lock"></i> {{ ucfirst($house->status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Property Description</h3>
                    <div class="prose max-w-none text-[#7a7268] leading-relaxed">
                        {!! nl2br(e($house->description)) !!}
                    </div>
                </div>

                <!-- Key Features -->
                <div class="mb-8">
                    <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4">Key Features</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                            <i class="fas fa-bed text-[#b87f3a] text-lg"></i>
                            <div>
                                <p class="text-xs text-[#7a7268]">Bedrooms</p>
                                <p class="font-semibold text-[#1a1714]">{{ $house->bedrooms }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                            <i class="fas fa-bath text-[#b87f3a] text-lg"></i>
                            <div>
                                <p class="text-xs text-[#7a7268]">Bathrooms</p>
                                <p class="font-semibold text-[#1a1714]">{{ $house->bathrooms }}</p>
                            </div>
                        </div>
                        @if($house->size_sqm)
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-ruler-combined text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Size</p>
                                    <p class="font-semibold text-[#1a1714]">{{ $house->size_sqm }} sqm</p>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                            <i class="fas fa-home text-[#b87f3a] text-lg"></i>
                            <div>
                                <p class="text-xs text-[#7a7268]">Type</p>
                                <p class="font-semibold text-[#1a1714]">{{ ucfirst($house->type) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                            <i class="fas fa-map-marker-alt text-[#b87f3a] text-lg"></i>
                            <div>
                                <p class="text-xs text-[#7a7268]">City</p>
                                <p class="font-semibold text-[#1a1714]">{{ $house->city }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                            <i class="fas fa-calendar-check text-[#b87f3a] text-lg"></i>
                            <div>
                                <p class="text-xs text-[#7a7268]">Status</p>
                                <p class="font-semibold text-[#1a1714]">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full 
                                            @if($house->status === 'available') bg-green-500 
                                            @elseif($house->status === 'rented') bg-red-500 
                                            @else bg-[#7a7268] @endif">
                                        </span>
                                        {{ ucfirst($house->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                @if($house->amenities && count($house->amenities) > 0)
                    <div class="mb-8">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Amenities</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($house->amenities as $amenity)
                                <span class="bg-[#f5f0e8] text-[#1a1714] px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                    <i class="fas fa-check-circle text-[#b87f3a] text-xs"></i>
                                    {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Gallery -->
                @if($house->images && $house->images->count() > 0)
                    <div>
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Property Gallery</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($house->images as $image)
                                <div class="rounded-lg overflow-hidden aspect-square bg-[#f5f0e8] hover:opacity-90 transition-opacity cursor-pointer" onclick="openLightbox('{{ $image->image_path }}', '{{ $image->alt_text ?? $house->title }}')">
                                    <img src="{{ $image->image_path }}" alt="{{ $image->alt_text ?? $house->title }}" class="w-full h-full object-cover">
                                    @if($image->is_cover)
                                        <div class="absolute bottom-2 left-2 bg-[#b87f3a] text-white text-[10px] font-semibold px-2 py-0.5 rounded">Cover</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Property Details Card -->
                <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                    <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-[#b87f3a]"></i> Property Details
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Location</p>
                                <p class="font-medium text-[#1a1714]">{{ $house->location }}</p>
                                <p class="text-xs text-[#7a7268]">{{ $house->city }}</p>
                                @if($house->address)
                                    <p class="text-xs text-[#7a7268]/60">{{ $house->address }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div>
                                <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Bedrooms</p>
                                <p class="font-medium text-[#1a1714]">{{ $house->bedrooms }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                <i class="fas fa-bath"></i>
                            </div>
                            <div>
                                <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Bathrooms</p>
                                <p class="font-medium text-[#1a1714]">{{ $house->bathrooms }}</p>
                            </div>
                        </div>

                        @if($house->size_sqm)
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                    <i class="fas fa-ruler-combined"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Size</p>
                                    <p class="font-medium text-[#1a1714]">{{ $house->size_sqm }} sqm</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Price</p>
                                <p class="font-medium text-[#1a1714] text-lg">
                                    {{ number_format($house->price, 0, ',', ',') }} {{ $house->currency }}
                                </p>
                                <p class="text-xs text-[#7a7268]">per {{ $house->price_period }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-[#ede7d8] rounded-lg flex items-center justify-center text-[#7a7268] flex-shrink-0">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Views</p>
                                <p class="font-medium text-[#1a1714]">{{ number_format($house->views_count) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Type -->
                <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                    <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                        <i class="fas fa-home text-[#b87f3a]"></i> Property Type
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-[#b87f3a]/10 rounded-full flex items-center justify-center text-[#b87f3a]">
                            <i class="fas fa-house text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-[#1a1714] text-lg">{{ ucfirst($house->type) }}</p>
                            <p class="text-sm text-[#7a7268]">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full 
                                        @if($house->status === 'available') bg-green-500 
                                        @elseif($house->status === 'rented') bg-red-500 
                                        @else bg-[#7a7268] @endif">
                                    </span>
                                    {{ ucfirst($house->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Share Property -->
                <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                    <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                        <i class="fas fa-share-alt text-[#b87f3a]"></i> Share This Property
                    </h3>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-[#1877f2] text-white rounded-full flex items-center justify-center hover:bg-[#166fe5] transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($house->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-[#000000] text-white rounded-full flex items-center justify-center hover:bg-[#1a1a1a] transition-colors">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($house->title . ' - ' . url()->current()) }}" target="_blank" class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:bg-[#1da851] transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($house->title) }}&body={{ urlencode('Check out this property: ' . url()->current()) }}" class="w-10 h-10 bg-[#7a7268] text-white rounded-full flex items-center justify-center hover:bg-[#6a6258] transition-colors">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    @if($house->status === 'available')
                        <a href="{{ route('contact') }}" class="block w-full text-center bg-[#b87f3a] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors">
                            <i class="fas fa-phone mr-2"></i> Inquire About This Property
                        </a>
                    @else
                        <div class="block w-full text-center bg-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg cursor-not-allowed">
                            <i class="fas fa-lock mr-2"></i> Not Available
                        </div>
                    @endif
                    <a href="{{ route('services.housing') }}" class="block w-full text-center border border-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Browse All Properties
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Properties -->
        @if($relatedHouses->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-[#ede7d8]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-display text-2xl font-semibold text-[#1a1714]">Similar Properties</h3>
                    <a href="{{ route('services.housing') }}" class="text-[#b87f3a] font-semibold hover:underline inline-flex items-center gap-1">
                        View All <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedHouses as $related)
                        <div class="group bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="relative h-40 overflow-hidden">
                                <img src="{{ $related->cover_image ?? asset('assets/housing/property-placeholder.jpg') }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @if($related->status === 'available')
                                    <span class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Available</span>
                                @elseif($related->status === 'rented')
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Rented</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="font-display font-semibold text-[#1a1714] text-sm truncate">{{ $related->title }}</h4>
                                <p class="text-xs text-[#7a7268] flex items-center gap-1 mt-1">
                                    <i class="fas fa-map-marker-alt text-[#b87f3a]"></i>
                                    {{ $related->location }}
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-sm font-semibold text-[#b87f3a]">{{ number_format($related->price, 0, ',', ',') }} {{ $related->currency }}</p>
                                    <a href="{{ route('services.house.show', $related->slug) }}" class="text-[#b87f3a] text-sm font-semibold hover:underline inline-flex items-center gap-1 group-hover:gap-2 transition-all">
                                        View <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">×</span>
    <img class="lightbox-img" id="lightboxImg" src="" alt="" />
</div>

<style>
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.92);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }

    .lightbox.open {
        display: flex;
    }

    .lightbox-img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 8px;
    }

    .lightbox-close {
        position: absolute;
        top: 24px;
        right: 32px;
        font-size: 32px;
        color: #fff;
        cursor: pointer;
        font-weight: 300;
        line-height: 1;
        transition: transform 0.2s;
    }

    .lightbox-close:hover {
        transform: scale(1.1);
    }
</style>

@push('scripts')
<script>
    // Lightbox functionality
    function openLightbox(src, alt) {
        const lb = document.getElementById('lightbox');
        const img = document.getElementById('lightboxImg');
        img.src = src;
        img.alt = alt || 'Property Image';
        lb.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close lightbox on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // Close on outside click
    document.getElementById('lightbox')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection