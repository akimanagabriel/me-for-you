@extends('layouts.public')

@section('title', $member->name . ' | ME FOR YOU')

@section('content')
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('team') }}" class="text-[#b87f3a] hover:underline inline-flex items-center gap-1 text-sm mb-6">
                <i class="fas fa-arrow-left text-xs"></i> Back to Team
            </a>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Profile Image -->
                <div>
                    <div class="rounded-xl overflow-hidden bg-[#f5f0e8]">
                        <img src="{{ $member->image ?? asset('assets/team/placeholder.jpg') }}" alt="{{ $member->name }}" class="w-full aspect-square object-cover">
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="md:col-span-2">
                    <h1 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714]">{{ $member->name }}</h1>
                    <p class="text-[#b87f3a] text-lg font-medium">{{ $member->position }}</p>
                    <p class="text-[#7a7268] text-sm mt-1">{{ $member->department }}</p>

                    @if($member->short_bio)
                        <p class="text-[#7a7268] mt-4 leading-relaxed">{{ $member->short_bio }}</p>
                    @endif

                    @if($member->bio)
                        <div class="mt-6 pt-6 border-t border-[#ede7d8]">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">About {{ $member->name }}</h3>
                            <p class="text-[#7a7268] leading-relaxed">{{ $member->bio }}</p>
                        </div>
                    @endif

                    @if($member->skills && count($member->skills) > 0)
                        <div class="mt-6 pt-6 border-t border-[#ede7d8]">
                            <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-3">Skills</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($member->skills as $skill)
                                    <span class="bg-[#f5f0e8] text-[#1a1714] px-3 py-1.5 rounded-lg text-sm">
                                        {{ ucfirst(str_replace('_', ' ', $skill)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($member->experience || $member->education)
                        <div class="mt-6 pt-6 border-t border-[#ede7d8] grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($member->experience)
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Experience</p>
                                    <p class="font-medium text-[#1a1714]">{{ $member->experience }}</p>
                                </div>
                            @endif
                            @if($member->education)
                                <div>
                                    <p class="text-xs text-[#7a7268] font-medium uppercase tracking-wider">Education</p>
                                    <p class="font-medium text-[#1a1714]">{{ $member->education }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($member->email || $member->phone)
                        <div class="mt-6 pt-6 border-t border-[#ede7d8] flex flex-wrap gap-4">
                            @if($member->email)
                                <a href="mailto:{{ $member->email }}" class="inline-flex items-center gap-2 text-[#b87f3a] hover:underline">
                                    <i class="fas fa-envelope"></i> {{ $member->email }}
                                </a>
                            @endif
                            @if($member->phone)
                                <a href="tel:{{ $member->phone }}" class="inline-flex items-center gap-2 text-[#b87f3a] hover:underline">
                                    <i class="fas fa-phone"></i> {{ $member->phone }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection