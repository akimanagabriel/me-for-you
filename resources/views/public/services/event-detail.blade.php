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
                    <li><a href="{{ route('services.events') }}" class="hover:text-[#b87f3a] transition-colors">Events</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs text-[#7a7268]/40"></i></li>
                    <li class="text-[#1a1714] font-medium truncate">{{ $event->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Event Detail -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Cover Image -->
                    <div class="rounded-xl overflow-hidden mb-6 bg-[#f5f0e8] relative">
                        @if ($event->cover_image)
                            <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
                        @else
                            <div class="w-full h-96 flex items-center justify-center bg-[#f5f0e8]">
                                <i class="fas fa-calendar-alt text-6xl text-[#b87f3a]/30"></i>
                            </div>
                        @endif
                        @if ($event->is_featured)
                            <span
                                class="absolute top-4 left-4 bg-[#b87f3a] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        @endif
                        @if ($event->status === 'active')
                            <span
                                class="absolute top-4 right-4 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> Active
                            </span>
                        @elseif($event->status === 'completed')
                            <span
                                class="absolute top-4 right-4 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-check-double mr-1"></i> Completed
                            </span>
                        @elseif($event->status === 'cancelled')
                            <span
                                class="absolute top-4 right-4 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i> Cancelled
                            </span>
                        @else
                            <span
                                class="absolute top-4 right-4 bg-[#7a7268] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ ucfirst($event->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- Title & Basic Info -->
                    <div class="mb-6">
                        <h1 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-3">{{ $event->title }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-[#7a7268]">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-tag text-[#b87f3a]"></i>
                                {{ ucfirst($event->category) }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-calendar-day text-[#b87f3a]"></i>
                                {{ $event->event_date->format('M d, Y') }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-[#b87f3a]"></i>
                                {{ $event->location }}
                            </span>
                            <span class="text-[#ede7d8]">|</span>
                            <span class="flex items-center gap-1">
                                <i class="far fa-eye text-[#7a7268]/40"></i>
                                {{ number_format($event->views_count) }} views
                            </span>
                        </div>
                    </div>

                    <!-- Price Highlight -->
                    <div class="bg-[#f5f0e8] border border-[#ede7d8] rounded-xl p-5 mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-[#7a7268]">Price</p>
                                @if ($event->price)
                                    <p class="font-display text-3xl font-semibold text-[#b87f3a]">
                                        {{ number_format($event->price, 0, ',', ',') }} {{ $event->currency }}
                                        @if ($event->price_period !== 'total')
                                            <span class="text-sm font-normal text-[#7a7268]">/
                                                {{ str_replace('_', ' ', $event->price_period) }}</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="font-display text-3xl font-semibold text-green-600">Free Event</p>
                                @endif
                            </div>
                            @if ($event->status === 'active')
                                <a href="{{ route('contact') }}"
                                    class="inline-flex items-center gap-2 bg-[#b87f3a] text-white px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors font-semibold">
                                    <i class="fas fa-phone"></i> Register Now
                                </a>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 bg-[#ede7d8] text-[#7a7268] px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                    <i class="fas fa-lock"></i> {{ ucfirst($event->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">About This Event</h3>
                        <div class="prose max-w-none text-[#7a7268] leading-relaxed">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <!-- Event Schedule -->
                    @if ($event->start_time || $event->end_time)
                        <div class="mb-8">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Event Schedule</h3>
                            <div class="bg-[#f5f0e8] rounded-xl p-4">
                                @if ($event->start_time)
                                    <div class="flex items-center gap-4 py-2">
                                        <div
                                            class="w-12 h-12 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a]">
                                            <i class="fas fa-play"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268]">Start Time</p>
                                            <p class="font-medium text-[#1a1714]">
                                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($event->end_time)
                                    <div class="flex items-center gap-4 py-2 border-t border-[#ede7d8]">
                                        <div
                                            class="w-12 h-12 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a]">
                                            <i class="fas fa-stop"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268]">End Time</p>
                                            <p class="font-medium text-[#1a1714]">
                                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Features -->
                    @if ($event->features && count($event->features) > 0)
                        <div class="mb-8">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Event Features</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($event->features as $feature)
                                    <span
                                        class="bg-[#f5f0e8] text-[#1a1714] px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                        <i class="fas fa-check-circle text-[#b87f3a] text-xs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Requirements -->
                    @if ($event->requirements && count($event->requirements) > 0)
                        <div class="mb-8">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Requirements</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($event->requirements as $requirement)
                                    <span
                                        class="bg-[#f5f0e8] text-[#1a1714] px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                        <i class="fas fa-exclamation-circle text-[#b87f3a] text-xs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $requirement)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Gallery -->
                    @if ($event->images && $event->images->count() > 0)
                        <div>
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Event Gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach ($event->images as $image)
                                    <div class="rounded-lg overflow-hidden aspect-square bg-[#f5f0e8] hover:opacity-90 transition-opacity cursor-pointer"
                                        onclick="openLightbox('{{ $image->image_path }}', '{{ $image->alt_text ?? $event->title }}')">
                                        <img src="{{ $image->image_path }}" alt="{{ $image->alt_text ?? $event->title }}"
                                            class="w-full h-full object-cover">
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Event Details Card -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-[#b87f3a]"></i> Event Details
                        </h3>

                        <div class="space-y-3 text-sm">
                            <!-- Date -->
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Date</p>
                                    <p class="font-medium text-[#1a1714]">{{ $event->event_date->format('l, F d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Time -->
                            @if ($event->start_time)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Time</p>
                                        <p class="font-medium text-[#1a1714]">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                            @if ($event->end_time)
                                                - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Location -->
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Location</p>
                                    <p class="font-medium text-[#1a1714]">{{ $event->location }}</p>
                                    <p class="text-xs text-[#7a7268]">{{ $event->city }}</p>
                                    @if ($event->venue)
                                        <p class="text-xs text-[#7a7268]">{{ $event->venue }}</p>
                                    @endif
                                    @if ($event->address)
                                        <p class="text-xs text-[#7a7268]/60">{{ $event->address }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Price</p>
                                    @if ($event->price)
                                        <p class="font-medium text-[#1a1714] text-lg">
                                            {{ number_format($event->price, 0, ',', ',') }} {{ $event->currency }}
                                            @if ($event->price_period !== 'total')
                                                <span class="text-xs text-[#7a7268] font-normal">/
                                                    {{ str_replace('_', ' ', $event->price_period) }}</span>
                                            @endif
                                        </p>
                                    @else
                                        <p class="font-medium text-green-600">Free Event</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Views -->
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 bg-[#ede7d8] rounded-lg flex items-center justify-center text-[#7a7268] flex-shrink-0">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Views</p>
                                    <p class="font-medium text-[#1a1714]">{{ number_format($event->views_count) }}</p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-9 h-9 bg-[#ede7d8] rounded-lg flex items-center justify-center text-[#7a7268] flex-shrink-0">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Status</p>
                                    <p class="font-medium text-[#1a1714]">
                                        <span class="inline-flex items-center gap-1.5">
                                            <span
                                                class="w-2 h-2 rounded-full 
                                            @if ($event->status === 'active') bg-green-500 
                                            @elseif($event->status === 'completed') bg-[#7a7268] 
                                            @elseif($event->status === 'cancelled') bg-red-500 
                                            @else bg-[#7a7268] @endif">
                                            </span>
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Speaker & Host -->
                    @if ($event->speaker || $event->host || $event->organizer)
                        <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                                <i class="fas fa-users text-[#b87f3a]"></i> Speaker & Host
                            </h3>
                            <div class="space-y-3 text-sm">
                                @if ($event->speaker)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Speaker
                                            </p>
                                            <p class="font-medium text-[#1a1714]">{{ $event->speaker }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($event->host)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                            <i class="fas fa-microphone"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Host</p>
                                            <p class="font-medium text-[#1a1714]">{{ $event->host }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if ($event->organizer)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">
                                                Organizer</p>
                                            <p class="font-medium text-[#1a1714]">{{ $event->organizer }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Contact -->
                    @if ($event->contact_email || $event->contact_phone)
                        <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                                <i class="fas fa-address-card text-[#b87f3a]"></i> Contact Information
                            </h3>
                            <div class="space-y-3 text-sm">
                                @if ($event->contact_email)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Email
                                            </p>
                                            <a href="mailto:{{ $event->contact_email }}"
                                                class="text-[#b87f3a] font-medium hover:underline">{{ $event->contact_email }}</a>
                                        </div>
                                    </div>
                                @endif
                                @if ($event->contact_phone)
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Phone
                                            </p>
                                            <a href="tel:{{ $event->contact_phone }}"
                                                class="text-[#b87f3a] font-medium hover:underline">{{ $event->contact_phone }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Share Event -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                        <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-share-nodes text-[#b87f3a]"></i> Share This Event
                        </h3>
                        <div class="flex gap-3">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank"
                                class="w-10 h-10 bg-[#1877f2] text-white rounded-full flex items-center justify-center hover:bg-[#166fe5] transition-colors">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . url()->current()) }}"
                                target="_blank"
                                class="w-10 h-10 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:bg-[#1da851] transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <!-- Email -->
                            <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode('Check out this event: ' . url()->current()) }}"
                                class="w-10 h-10 bg-[#7a7268] text-white rounded-full flex items-center justify-center hover:bg-[#6a6258] transition-colors">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        @if ($event->status === 'active')
                            <a href="{{ route('contact') }}"
                                class="block w-full text-center bg-[#b87f3a] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors">
                                <i class="fas fa-ticket-alt mr-2"></i> Register for This Event
                            </a>
                        @else
                            <div
                                class="block w-full text-center bg-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i> Registration Closed
                            </div>
                        @endif
                        <a href="{{ route('services.events') }}"
                            class="block w-full text-center border border-[#ede7d8] text-[#7a7268] font-semibold px-6 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Browse All Events
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Events -->
            @if ($relatedEvents->isNotEmpty())
                <div class="mt-16 pt-10 border-t border-[#ede7d8]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-display text-2xl font-semibold text-[#1a1714]">Related Events</h3>
                        <a href="{{ route('services.events') }}"
                            class="text-[#b87f3a] font-semibold hover:underline inline-flex items-center gap-1">
                            View All <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedEvents as $related)
                            <div
                                class="group bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="relative h-40 overflow-hidden">
                                    <img src="{{ $related->cover_image ?? asset('assets/events/event-placeholder.jpg') }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if ($related->status === 'active')
                                        <span
                                            class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Active</span>
                                    @elseif($related->status === 'completed')
                                        <span
                                            class="absolute top-2 right-2 bg-[#7a7268] text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">Completed</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-display font-semibold text-[#1a1714] text-sm truncate">
                                        {{ $related->title }}</h4>
                                    <p class="text-xs text-[#7a7268] flex items-center gap-1 mt-1">
                                        <i class="fas fa-calendar-day text-[#b87f3a]"></i>
                                        {{ $related->event_date->format('M d, Y') }}
                                    </p>
                                    <a href="{{ route('services.event.show', $related->slug) }}"
                                        class="mt-2 inline-flex items-center gap-1 text-[#b87f3a] text-sm font-semibold hover:underline group-hover:gap-2 transition-all">
                                        View Details <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
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
                img.alt = alt || 'Event Image';
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
