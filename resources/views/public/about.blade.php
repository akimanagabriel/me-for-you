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
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">About Us</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-6">
                Your Professional Companion,<br />
                <span class="text-[#d49d6a]">Every Step of the Way</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed">
                ME FOR YOU ADVISORY Ltd is a Kigali-based company offering trusted housing, transport, 
                and event management services.
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Our Mission</p>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-6">
                Empowering Lives Through <span class="text-[#b87f3a]">Trusted Services</span>
            </h2>
            <p class="text-lg text-[#7a7268] leading-relaxed max-w-3xl mx-auto">
                We help individuals and businesses move through life's biggest milestones   
                from finding a home, to getting around the city, to celebrating unforgettable events   
                with confidence and care.
            </p>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Our Impact</p>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">By the Numbers</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-[#b87f3a] text-2xl"></i>
                </div>
                <p class="font-display text-4xl font-semibold text-[#1a1714]">{{ number_format($stats['clients']) }}+</p>
                <p class="text-sm text-[#7a7268] mt-1">Happy Clients</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-home text-[#b87f3a] text-2xl"></i>
                </div>
                <p class="font-display text-4xl font-semibold text-[#1a1714]">{{ number_format($stats['properties']) }}+</p>
                <p class="text-sm text-[#7a7268] mt-1">Properties Managed</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-[#b87f3a] text-2xl"></i>
                </div>
                <p class="font-display text-4xl font-semibold text-[#1a1714]">{{ number_format($stats['events']) }}+</p>
                <p class="text-sm text-[#7a7268] mt-1">Events Delivered</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-car text-[#b87f3a] text-2xl"></i>
                </div>
                <p class="font-display text-4xl font-semibold text-[#1a1714]">{{ number_format($stats['vehicles']) }}+</p>
                <p class="text-sm text-[#7a7268] mt-1">Vehicles in Fleet</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Our Values</p>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">What Drives Us</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="text-center p-8 rounded-xl bg-[#f5f0e8] hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Professionalism</h3>
                <p class="text-[#7a7268] leading-relaxed">Expert service at every touchpoint, from first call to final delivery.</p>
            </div>
            <div class="text-center p-8 rounded-xl bg-[#f5f0e8] hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-coins text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Affordability</h3>
                <p class="text-[#7a7268] leading-relaxed">Premium quality without premium prices   value you can trust.</p>
            </div>
            <div class="text-center p-8 rounded-xl bg-[#f5f0e8] hover:shadow-lg transition-shadow duration-300">
                <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-[#b87f3a] text-2xl"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Trustworthiness</h3>
                <p class="text-[#7a7268] leading-relaxed">We show up, deliver, and stand behind everything we promise.</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">What We Do</p>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Our Core Services</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <a href="{{ route('services.housing') }}" class="group bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-[#ede7d8] hover:border-[#b87f3a]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-full flex items-center justify-center group-hover:bg-[#b87f3a]/20 transition-colors">
                        <i class="fas fa-home text-[#b87f3a] text-xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-[#1a1714]">Housing</h3>
                </div>
                <p class="text-[#7a7268] leading-relaxed">Find your perfect home or investment property with our expert guidance.</p>
                <p class="text-[#b87f3a] font-semibold mt-3 group-hover:underline inline-flex items-center gap-2">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </p>
            </a>

            <a href="{{ route('services.events') }}" class="group bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-[#ede7d8] hover:border-[#b87f3a]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-full flex items-center justify-center group-hover:bg-[#b87f3a]/20 transition-colors">
                        <i class="fas fa-calendar-alt text-[#b87f3a] text-xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-[#1a1714]">Events</h3>
                </div>
                <p class="text-[#7a7268] leading-relaxed">Create unforgettable moments with our professional event management.</p>
                <p class="text-[#b87f3a] font-semibold mt-3 group-hover:underline inline-flex items-center gap-2">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </p>
            </a>

            <a href="{{ route('services.transport') }}" class="group bg-white rounded-xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-[#ede7d8] hover:border-[#b87f3a]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-full flex items-center justify-center group-hover:bg-[#b87f3a]/20 transition-colors">
                        <i class="fas fa-car text-[#b87f3a] text-xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-semibold text-[#1a1714]">Transport</h3>
                </div>
                <p class="text-[#7a7268] leading-relaxed">Reliable, comfortable, and affordable transport solutions for all needs.</p>
                <p class="text-[#b87f3a] font-semibold mt-3 group-hover:underline inline-flex items-center gap-2">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </p>
            </a>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            <div>
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Our Story</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-6">
                    Building Trust, <span class="text-[#b87f3a]">One Service at a Time</span>
                </h2>
                <p class="text-[#7a7268] leading-relaxed mb-4">
                    Founded in Kigali, ME FOR YOU ADVISORY Ltd was born from a simple idea: 
                    to provide professional, reliable, and personalized services that make life easier.
                </p>
                <p class="text-[#7a7268] leading-relaxed mb-4">
                    We understand that finding a home, planning an event, or getting around 
                    can be challenging. That's why we're here   to handle the details so you 
                    can focus on what matters most.
                </p>
                <p class="text-[#7a7268] leading-relaxed mb-6">
                    Today, we're proud to serve individuals and businesses across Rwanda, 
                    helping them navigate life's milestones with confidence and peace of mind.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-[#b87f3a] hover:bg-[#8a6e22] text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                    <i class="fas fa-phone"></i> Get in Touch
                </a>
            </div>
            <div class="relative">
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('assets/gallery/about-brand.webp') }}" alt="About ME FOR YOU" class="w-full h-96 object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[#b87f3a] rounded-xl opacity-10 -z-10"></div>
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-[#b87f3a] rounded-xl opacity-10 -z-10"></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-[#b87f3a]">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="font-display text-3xl md:text-4xl font-semibold mb-4">Ready to Work With Us?</h2>
        <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto leading-relaxed">
            Whether you need a home, a ride, or an event to remember   we're here to help.
        </p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-[#8a6e22] font-semibold px-8 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
            <i class="fas fa-paper-plane"></i> Contact Us Today
        </a>
    </div>
</section>
@endsection