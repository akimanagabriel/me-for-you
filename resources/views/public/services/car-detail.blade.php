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
                    <li><a href="{{ route('services.transport') }}"
                            class="hover:text-[#b87f3a] transition-colors">Transport</a></li>
                    <li><i class="fas fa-chevron-right text-xs text-[#7a7268]/40"></i></li>
                    <li class="text-[#1a1714] font-medium truncate">{{ $car->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Car Detail -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Cover Image -->
                    <div class="rounded-xl overflow-hidden mb-6 bg-[#f5f0e8] relative">
                        @if ($car->cover_image)
                            <img src="{{ $car->cover_image }}" alt="{{ $car->title }}" class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 flex items-center justify-center bg-[#f5f0e8]">
                                <i class="fas fa-car text-6xl text-[#b87f3a]/30"></i>
                            </div>
                        @endif
                        @if ($car->is_featured)
                            <span
                                class="absolute top-4 left-4 bg-[#b87f3a] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        @endif
                        @if ($car->status === 'available')
                            <span
                                class="absolute top-4 right-4 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> Available
                            </span>
                        @elseif($car->status === 'reserved')
                            <span
                                class="absolute top-4 right-4 bg-yellow-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-clock mr-1"></i> Reserved
                            </span>
                        @elseif($car->status === 'sold')
                            <span
                                class="absolute top-4 right-4 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i> Sold
                            </span>
                        @else
                            <span
                                class="absolute top-4 right-4 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ ucfirst($car->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- Title & Basic Info -->
                    <div class="mb-6">
                        <h1 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-3">{{ $car->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-[#7a7268]">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-car text-[#b87f3a]"></i>
                                {{ $car->make }} {{ $car->model }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-alt text-[#b87f3a]"></i>
                                {{ $car->year }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-tag text-[#b87f3a]"></i>
                                {{ ucfirst($car->body_type) }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="far fa-eye text-[#7a7268]/40"></i>
                                {{ number_format($car->views_count) }} views
                            </span>
                        </div>
                    </div>

                    <!-- Price Highlight -->
                    <div class="bg-[#f5f0e8] border border-[#ede7d8] rounded-xl p-5 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-[#7a7268]">Price</p>
                                <p class="font-display text-3xl font-semibold text-[#b87f3a]">
                                    {{ number_format($car->price, 0, ',', ',') }} {{ $car->currency }}
                                    @if ($car->price_period !== 'total')
                                        <span class="text-sm font-normal text-[#7a7268]">/ {{ $car->price_period }}</span>
                                    @endif
                                </p>
                            </div>
                            @if ($car->status === 'available')
                                <a href="{{ route('contact') }}"
                                    class="inline-flex items-center gap-2 bg-[#b87f3a] text-white px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors font-semibold">
                                    <i class="fas fa-phone"></i> Inquire Now
                                </a>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 bg-[#ede7d8] text-[#7a7268] px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                    <i class="fas fa-lock"></i> {{ ucfirst($car->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Vehicle Description</h3>
                        <div class="prose max-w-none text-[#7a7268] leading-relaxed">
                            {!! nl2br(e($car->description)) !!}
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="mb-8">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4">Specifications</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-tachometer-alt text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Mileage</p>
                                    <p class="font-semibold text-[#1a1714]">{{ number_format($car->mileage) }} km</p>
                                </div>
                            </div>
                            @if ($car->engine_capacity)
                                <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                    <i class="fas fa-microchip text-[#b87f3a] text-lg"></i>
                                    <div>
                                        <p class="text-xs text-[#7a7268]">Engine</p>
                                        <p class="font-semibold text-[#1a1714]">{{ $car->engine_capacity }} L</p>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-users text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Seats</p>
                                    <p class="font-semibold text-[#1a1714]">{{ $car->seats }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-door-open text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Doors</p>
                                    <p class="font-semibold text-[#1a1714]">{{ $car->doors }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-cog text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Transmission</p>
                                    <p class="font-semibold text-[#1a1714]">{{ ucfirst($car->transmission) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-gas-pump text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Fuel Type</p>
                                    <p class="font-semibold text-[#1a1714]">{{ ucfirst($car->fuel_type) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-palette text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Color</p>
                                    <p class="font-semibold text-[#1a1714]">{{ $car->color ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                <i class="fas fa-tag text-[#b87f3a] text-lg"></i>
                                <div>
                                    <p class="text-xs text-[#7a7268]">Condition</p>
                                    <p class="font-semibold text-[#1a1714]">
                                        {{ ucwords(str_replace('_', ' ', $car->condition)) }}</p>
                                </div>
                            </div>
                            @if ($car->vin)
                                <div class="flex items-center gap-3 p-3 bg-[#f5f0e8] rounded-lg">
                                    <i class="fas fa-fingerprint text-[#b87f3a] text-lg"></i>
                                    <div>
                                        <p class="text-xs text-[#7a7268]">VIN</p>
                                        <p class="font-semibold text-[#1a1714] text-xs">{{ $car->vin }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Features -->
                    @if ($car->features && count($car->features) > 0)
                        <div class="mb-8">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Features</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($car->features as $feature)
                                    <span
                                        class="bg-[#f5f0e8] text-[#1a1714] px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                        <i class="fas fa-check-circle text-[#b87f3a] text-xs"></i>
                                        {{ ucwords(str_replace('_', ' ', $feature)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Gallery -->
                    @if ($car->images && $car->images->count() > 0)
                        <div>
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Vehicle Gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach ($car->images as $image)
                                    <div class="rounded-lg overflow-hidden aspect-square bg-[#f5f0e8] hover:opacity-90 transition-opacity cursor-pointer"
                                        onclick="openLightbox('{{ $image->image_path }}', '{{ $image->alt_text ?? $car->title }}')">
                                        <img src="{{ $image->image_path }}" alt="{{ $image->alt_text ?? $car->title }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Contact Card -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                            <i class="fas fa-phone text-[#b87f3a]"></i> Contact Us
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-3 bg-white rounded-lg">
                                <div
                                    class="w-12 h-12 bg-[#b87f3a]/10 rounded-full flex items-center justify-center text-[#b87f3a] text-xl font-bold">
                                    ME
                                </div>
                                <div>
                                    <p class="font-semibold text-[#1a1714]">ME FOR YOU Team</p>
                                    <p class="text-sm text-[#7a7268]">Professional Transport Services</p>
                                </div>
                            </div>
                            <a href="tel:+250788202209"
                                class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-[#f5f0e8] transition-colors">
                                <i class="fas fa-phone text-[#b87f3a]"></i>
                                <span class="text-[#1a1714]">+250 788 202 209</span>
                            </a>
                            <a href="mailto:info@me-for-you.org"
                                class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-[#f5f0e8] transition-colors">
                                <i class="fas fa-envelope text-[#b87f3a]"></i>
                                <span class="text-[#1a1714]">info@me-for-you.org</span>
                            </a>
                            <a href="https://wa.me/+250788202209" target="_blank"
                                class="flex items-center gap-3 p-3 bg-white rounded-lg hover:bg-[#f5f0e8] transition-colors">
                                <i class="fab fa-whatsapp text-[#25D366]"></i>
                                <span class="text-[#1a1714]">Chat on WhatsApp</span>
                            </a>
                        </div>
                        <a href="{{ route('contact') }}"
                            class="mt-4 block w-full text-center bg-[#b87f3a] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i> Send Message
                        </a>
                    </div>

                    <!-- Quick Details -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                            <i class="fas fa-list-ul text-[#b87f3a]"></i> Quick Details
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between py-2 border-b border-[#ede7d8]">
                                <span class="text-[#7a7268]">Make</span>
                                <span class="font-medium text-[#1a1714]">{{ $car->make }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-[#ede7d8]">
                                <span class="text-[#7a7268]">Model</span>
                                <span class="font-medium text-[#1a1714]">{{ $car->model }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-[#ede7d8]">
                                <span class="text-[#7a7268]">Year</span>
                                <span class="font-medium text-[#1a1714]">{{ $car->year }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-[#ede7d8]">
                                <span class="text-[#7a7268]">Body Type</span>
                                <span class="font-medium text-[#1a1714]">{{ ucfirst($car->body_type) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-[#ede7d8]">
                                <span class="text-[#7a7268]">Transmission</span>
                                <span class="font-medium text-[#1a1714]">{{ ucfirst($car->transmission) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-[#7a7268]">Fuel Type</span>
                                <span class="font-medium text-[#1a1714]">{{ ucfirst($car->fuel_type) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Share Vehicle -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-[#b87f3a]"></i> Share This Vehicle
                        </h3>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="w-10 h-10 bg-[#1877f2] text-white rounded-full flex items-center justify-center hover:bg-[#166fe5] transition-colors">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>

                            <a href="https://wa.me/?text={{ urlencode($car->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:bg-[#1da851] transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($car->title) }}&body={{ urlencode('Check out this vehicle: ' . url()->current()) }}"
                                class="w-10 h-10 bg-[#7a7268] text-white rounded-full flex items-center justify-center hover:bg-[#6a6258] transition-colors">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if ($car->status === 'available')
                            <a href="{{ route('contact') }}"
                                class="block w-full text-center bg-[#b87f3a] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors">
                                <i class="fas fa-phone mr-2"></i> Inquire About This Vehicle
                            </a>
                        @else
                            <div
                                class="block w-full text-center bg-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i> Not Available
                            </div>
                        @endif
                        <a href="{{ route('services.transport') }}"
                            class="block w-full text-center border border-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Browse All Vehicles
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Vehicles -->
            @if ($relatedCars->isNotEmpty())
                <div class="mt-16 pt-10 border-t border-[#ede7d8]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-display text-2xl font-semibold text-[#1a1714]">Similar Vehicles</h3>
                        <a href="{{ route('services.transport') }}"
                            class="text-[#b87f3a] font-semibold hover:underline inline-flex items-center gap-1">
                            View All <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedCars as $related)
                            <div
                                class="group bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $related->cover_image ?? asset('assets/transport/car-placeholder.jpg') }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if ($related->status === 'available')
                                        <span
                                            class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Available</span>
                                    @elseif($related->status === 'reserved')
                                        <span
                                            class="absolute top-2 right-2 bg-yellow-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Reserved</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-display font-semibold text-[#1a1714] text-sm truncate">
                                        {{ $related->title }}</h4>
                                    <p class="text-xs text-[#7a7268] flex items-center gap-1 mt-1">
                                        <i class="fas fa-car text-[#b87f3a]"></i>
                                        {{ $related->make }} {{ $related->model }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-sm font-semibold text-[#b87f3a]">
                                            {{ number_format($related->price, 0, ',', ',') }} {{ $related->currency }}</p>
                                        <a href="{{ route('services.car.show', $related->slug) }}"
                                            class="text-[#b87f3a] text-sm font-semibold hover:underline inline-flex items-center gap-1 group-hover:gap-2 transition-all">
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
                img.alt = alt || 'Vehicle Image';
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
