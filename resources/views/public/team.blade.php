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
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Our Team</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-4">
                Meet the <span class="text-[#d49d6a]">Team</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed">
                The passionate professionals behind ME FOR YOU, dedicated to delivering excellence in housing, events, and transport services.
            </p>
        </div>
    </div>
</section>

{{-- BIG FEATURED LEADER --}}
@if($featuredMembers->isNotEmpty())
    @php
        $leader = $featuredMembers->first();
        $otherFeatured = $featuredMembers->slice(1);
    @endphp

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Leadership</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Our Founder &amp; CEO</h2>
            </div>

            {{-- Leader Card --}}
            <div class="max-w-3xl mx-auto bg-[#f5f0e8] rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                    {{-- Image --}}
                    <div class="md:col-span-2 aspect-square overflow-hidden bg-[#ede7d8]">
                        <img src="{{ $leader->image ?? asset('assets/team/placeholder.jpg') }}" 
                             alt="{{ $leader->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    {{-- Info --}}
                    <div class="md:col-span-3 p-6 md:p-8 flex flex-col justify-center">
                        <h3 class="font-display text-2xl md:text-3xl font-semibold text-[#1a1714]">{{ $leader->name }}</h3>
                        <p class="text-[#b87f3a] text-lg font-medium">{{ $leader->position }}</p>
                        <p class="text-sm text-[#7a7268] mt-3 leading-relaxed">{{ $leader->short_bio ?? $leader->bio }}</p>
                        <a href="{{ route('team.show', $leader->slug) }}" 
                           class="mt-6 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline group">
                            View Full Profile 
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

{{-- OTHER FEATURED MEMBERS --}}
@if($otherFeatured->isNotEmpty())
    <section class="py-16 bg-white border-t border-[#ede7d8]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-2">Leadership Team</p>
                <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Other Leaders</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                @foreach($otherFeatured as $member)
                    <div class="bg-[#f5f0e8] rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $member->image ?? asset('assets/team/placeholder.jpg') }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-display text-lg font-semibold text-[#1a1714]">{{ $member->name }}</h3>
                            <p class="text-[#b87f3a] text-sm font-medium">{{ $member->position }}</p>
                            <p class="text-sm text-[#7a7268] mt-1 line-clamp-2">{{ $member->short_bio }}</p>
                            <a href="{{ route('team.show', $member->slug) }}" 
                               class="mt-3 inline-flex items-center gap-2 text-[#b87f3a] font-semibold hover:underline text-sm group">
                                View Profile 
                                <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ALL MEMBERS --}}
<section class="py-16 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">Our Team</h2>
            <p class="text-[#7a7268] mt-2 max-w-2xl mx-auto">Meet the dedicated professionals who make ME FOR YOU exceptional.</p>
        </div>

        @if($members->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                @foreach($members as $member)
                    <a href="{{ route('team.show', $member->slug) }}" class="group bg-white rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $member->image ?? asset('assets/team/placeholder.jpg') }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 text-center">
                            <h4 class="font-display font-semibold text-[#1a1714]">{{ $member->name }}</h4>
                            <p class="text-xs text-[#b87f3a]">{{ $member->position }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-[#7a7268]">No team members available.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-[#b87f3a]">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="font-display text-3xl md:text-4xl font-semibold mb-4">Ready to Work With Us?</h2>
        <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto">Let our expert team help you with housing, events, or transport services.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-[#8a6e22] font-semibold px-8 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
            Get in Touch <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
</section>
@endsection