@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#1a1714] text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Gallery</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-4">
                Our Work, <br /><span class="text-[#d49d6a]">In Pictures</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed">
                A glimpse into the properties we've placed, events we've produced, and journeys we've made comfortable.
            </p>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-2 mb-10">
            <button class="gallery-filter px-5 py-2 rounded-lg text-sm font-medium bg-[#b87f3a] text-white transition-colors" data-filter="all">
                All
            </button>
            <button class="gallery-filter px-5 py-2 rounded-lg text-sm font-medium bg-[#f5f0e8] text-[#1a1714] hover:bg-[#ede7d8] transition-colors" data-filter="housing">
                Housing
            </button>
            <button class="gallery-filter px-5 py-2 rounded-lg text-sm font-medium bg-[#f5f0e8] text-[#1a1714] hover:bg-[#ede7d8] transition-colors" data-filter="events">
                Events
            </button>
            <button class="gallery-filter px-5 py-2 rounded-lg text-sm font-medium bg-[#f5f0e8] text-[#1a1714] hover:bg-[#ede7d8] transition-colors" data-filter="transport">
                Transport
            </button>
        </div>

        @if($images->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" id="galleryGrid">
                @foreach($images as $image)
                    <div class="gallery-item group relative rounded-xl overflow-hidden bg-[#f5f0e8] aspect-square cursor-pointer" 
                         data-category="{{ $image['category'] }}"
                         onclick="openLightbox('{{ $image['src'] }}', '{{ $image['alt'] }}', '{{ $image['category'] }}')">
                        <img src="{{ $image['src'] }}" 
                             alt="{{ $image['alt'] }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1714]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <span class="text-white font-display text-sm font-semibold">{{ $image['alt'] }}</span>
                            <span class="text-white/70 text-xs">{{ ucfirst($image['category']) }}</span>
                        </div>
                        @if(isset($image['featured']) && $image['featured'])
                            <span class="absolute top-3 left-3 bg-[#b87f3a] text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        @endif
                        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="bg-white/90 text-[#1a1714] text-xs font-semibold px-2 py-1 rounded-lg backdrop-blur-sm">
                                <i class="fas fa-expand"></i>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State for filtered results -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="w-20 h-20 bg-[#f5f0e8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-3xl text-[#b87f3a]/40"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">No images found</h3>
                <p class="text-[#7a7268]">Try selecting a different category.</p>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-[#f5f0e8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-3xl text-[#b87f3a]/40"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">No images available</h3>
                <p class="text-[#7a7268]">Check back soon for updates.</p>
            </div>
        @endif
    </div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">×</span>
    <div class="lightbox-content">
        <img class="lightbox-img" id="lightboxImg" src="" alt="" />
        <div class="lightbox-info" id="lightboxInfo">
            <p class="lightbox-title" id="lightboxTitle"></p>
            <p class="lightbox-category" id="lightboxCategory"></p>
        </div>
    </div>
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
        padding: 20px;
    }

    .lightbox.open {
        display: flex;
    }

    .lightbox-content {
        position: relative;
        max-width: 90vw;
        max-height: 90vh;
    }

    .lightbox-img {
        max-width: 90vw;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 8px;
    }

    .lightbox-info {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        text-align: center;
        color: #fff;
        padding: 10px 20px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 8px;
        backdrop-filter: blur(8px);
    }

    .lightbox-title {
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .lightbox-category {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.6);
    }

    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        font-size: 32px;
        color: #fff;
        cursor: pointer;
        font-weight: 300;
        line-height: 1;
        transition: transform 0.2s;
        z-index: 201;
    }

    .lightbox-close:hover {
        transform: scale(1.1);
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
    }

    .gallery-item .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(26, 23, 20, 0.8) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 16px;
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    .gallery-filter.active {
        background: #b87f3a;
        color: white;
    }
</style>

@push('scripts')
<script>
    // Lightbox functionality
    function openLightbox(src, alt, category) {
        const lb = document.getElementById('lightbox');
        const img = document.getElementById('lightboxImg');
        const title = document.getElementById('lightboxTitle');
        const cat = document.getElementById('lightboxCategory');
        
        img.src = src;
        img.alt = alt || 'Gallery Image';
        title.textContent = alt || 'Untitled';
        cat.textContent = category ? ucfirst(category) : '';
        
        lb.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
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

    // Gallery filtering
    document.addEventListener('DOMContentLoaded', function() {
        const filters = document.querySelectorAll('.gallery-filter');
        const items = document.querySelectorAll('.gallery-item');
        const noResults = document.getElementById('noResults');

        filters.forEach(filter => {
            filter.addEventListener('click', function() {
                // Update active state
                filters.forEach(f => f.classList.remove('bg-[#b87f3a]', 'text-white', 'bg-[#f5f0e8]', 'text-[#1a1714]'));
                this.classList.add('bg-[#b87f3a]', 'text-white');
                this.classList.remove('bg-[#f5f0e8]', 'text-[#1a1714]');

                const category = this.dataset.filter;
                let visibleCount = 0;

                items.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide no results
                if (visibleCount === 0 && category !== 'all') {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
@endsection