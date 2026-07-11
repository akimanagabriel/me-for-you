@props(['transparent' => false])

<nav
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
    :class="scrolled ? 'bg-base-100/95 backdrop-blur-md shadow-sm' : '{{ $transparent ? 'bg-transparent' : 'bg-base-100' }}'"
    class="fixed top-0 left-0 right-0 z-50 px-6 transition-all duration-300"
    id="mainNav"
>
    <div class="max-w-[1200px] mx-auto h-[72px] flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 font-display text-xl font-semibold tracking-wide z-[2]"
           :class="scrolled ? 'text-base-content' : '{{ $transparent ? 'text-white' : 'text-base-content' }}'">
            <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU Logo" class="w-10 h-10 object-contain" />
            <span>ME <span class="text-primary">FOR</span> YOU</span>
        </a>

        {{-- Desktop links --}}
        <ul class="hidden md:flex items-center gap-8">
            <li><a href="{{ route('about') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">About</a></li>
            <li><a href="{{ route('houses.index') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Housing</a></li>
            <li><a href="{{ route('events.index') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Events</a></li>
            <li><a href="{{ route('cars.index') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Transport</a></li>
            <li><a href="{{ route('gallery') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Gallery</a></li>
            <li><a href="{{ route('contact') }}" class="btn btn-primary btn-sm text-[13px]">Get in Touch</a></li>
            @guest
                @if (Route::has('login'))
                    <li><a href="{{ route('login') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Login</a></li>
                @endif
            @else
                <li><a href="{{ route('admin.dashboard') }}" class="text-[13px] font-medium tracking-wide hover:text-primary transition-colors" :class="scrolled ? 'text-base-content/80' : '{{ $transparent ? 'text-white/85' : 'text-base-content/80' }}'">Dashboard</a></li>
            @endguest
        </ul>

        {{-- Mobile hamburger --}}
        <button
            @click="open = !open; document.body.style.overflow = open ? 'hidden' : ''"
            class="md:hidden flex flex-col justify-center items-center gap-1.5 w-10 h-10 z-[2]"
            :aria-expanded="open"
            aria-label="Toggle menu"
        >
            <span class="block w-6 h-0.5 rounded transition-all duration-300" :class="[scrolled ? 'bg-base-content' : '{{ $transparent ? 'bg-white' : 'bg-base-content' }}', open ? 'rotate-45 translate-y-2' : '']"></span>
            <span class="block w-6 h-0.5 rounded transition-all duration-300" :class="[scrolled ? 'bg-base-content' : '{{ $transparent ? 'bg-white' : 'bg-base-content' }}', open ? 'opacity-0' : '']"></span>
            <span class="block w-6 h-0.5 rounded transition-all duration-300" :class="[scrolled ? 'bg-base-content' : '{{ $transparent ? 'bg-white' : 'bg-base-content' }}', open ? '-rotate-45 -translate-y-2' : '']"></span>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="open"
        x-transition
        @click.away="open = false; document.body.style.overflow = ''"
        class="md:hidden fixed top-[72px] left-0 right-0 bg-neutral/97 backdrop-blur-lg px-6 z-[49]"
        x-cloak
    >
        <a href="{{ route('about') }}" @click="open = false" class="block py-3.5 text-[15px] font-medium text-white/80 border-b border-white/10 hover:text-accent transition-colors">About</a>
        <a href="{{ route('houses.index') }}" @click="open = false" class="block py-3.5 text-[15px] font-medium text-white/80 border-b border-white/10 hover:text-accent transition-colors">Housing</a>
        <a href="{{ route('events.index') }}" @click="open = false" class="block py-3.5 text-[15px] font-medium text-white/80 border-b border-white/10 hover:text-accent transition-colors">Events</a>
        <a href="{{ route('cars.index') }}" @click="open = false" class="block py-3.5 text-[15px] font-medium text-white/80 border-b border-white/10 hover:text-accent transition-colors">Transport</a>
        <a href="{{ route('gallery') }}" @click="open = false" class="block py-3.5 text-[15px] font-medium text-white/80 border-b border-white/10 hover:text-accent transition-colors">Gallery</a>
        <a href="{{ route('contact') }}" @click="open = false" class="block mt-4 mb-6 text-center btn btn-primary">Get in Touch</a>
    </div>
</nav>
