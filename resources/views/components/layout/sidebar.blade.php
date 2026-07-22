@php
    $navItems = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.houses.index', 'label' => 'Houses', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'admin.cars.index', 'label' => 'Cars', 'icon' => 'M8 7h8m-8 4h8m-4 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z'],
        ['route' => 'admin.events.index', 'label' => 'Events', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        // 👇 NEW: Team Members menu item
        ['route' => 'admin.team-members.index', 'label' => 'Team Members', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        // 👆 Team Members added here

        // Additional menu items (commented out remain as they were)
        // ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => '...'],
        // ...
        ['route' => 'admin.profile.index', 'label' => 'Profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
    ];
@endphp

<aside class="drawer-side z-40">
    <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="bg-base-100 border-r border-base-300 w-64 min-h-full flex flex-col">
        <div class="p-5 border-b border-base-300">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU" class="w-9 h-9 object-contain" />
                <div>
                    <span class="font-display text-lg font-semibold leading-none">ME <span class="text-primary">FOR</span> YOU</span>
                    <p class="text-[10px] uppercase tracking-widest text-base-content/50 mt-0.5">Admin Panel</p>
                </div>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto p-3 space-y-0.5">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="admin-nav-link {{ request()->routeIs(str_replace('.index', '.*', $item['route'])) || request()->routeIs($item['route']) ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-base-300">
            <a href="{{ url('/') }}" class="btn btn-ghost btn-sm w-full justify-start gap-2 text-base-content/60">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Website
            </a>
        </div>
    </div>
</aside>