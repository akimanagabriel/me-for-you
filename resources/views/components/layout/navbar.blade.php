@props(['breadcrumbs' => []])

<header class="navbar bg-base-100 border-b border-base-300 px-4 lg:px-6 min-h-16 sticky top-0 z-30">
    <div class="flex-none lg:hidden">
        <label for="admin-drawer" class="btn btn-square btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
    </div>

    <div class="flex-1">
        @if (count($breadcrumbs))
            <div class="breadcrumbs text-sm hidden sm:block">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}"
                           class="text-base-content/60 hover:text-primary">Dashboard</a></li>
                    @foreach ($breadcrumbs as $crumb)
                        @if ($loop->last)
                            <li class="text-base-content font-medium">{{ $crumb['label'] }}</li>
                        @else
                            <li><a href="{{ $crumb['url'] ?? '#' }}"
                                   class="text-base-content/60 hover:text-primary">{{ $crumb['label'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @else
            <h1 class="font-display text-xl font-semibold">{{ $title ?? 'Dashboard' }}</h1>
        @endif
    </div>

    <div class="flex-none flex items-center gap-2">

        {{-- Notifications --}}
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle btn-sm">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="h-4 w-4 rounded-full text-white bg-primary indicator-item">3</span>
                </div>
            </div>
            <div tabindex="0"
                 class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-80 border border-base-300 mt-2">
                <div class="px-3 py-2 border-b border-base-300">
                    <p class="font-semibold text-sm">Notifications</p>
                </div>
                <ul class="max-h-64 overflow-y-auto">
                    <li><a class="text-sm py-2"><x-ui.badge variant="warning" size="xs">New</x-ui.badge> Pending inquiry
                            from John D.</a></li>
                    <li><a class="text-sm py-2"><x-ui.badge variant="info" size="xs">Booking</x-ui.badge> New house
                            booking request</a></li>
                    <li><a class="text-sm py-2"><x-ui.badge variant="success" size="xs">Review</x-ui.badge> New 5-star
                            review received</a></li>
                </ul>
                <div class="px-3 py-2 border-t border-base-300">
                    <a href="{{ route('admin.inquiries.index') }}" class="text-xs text-primary hover:underline">View all
                        notifications</a>
                </div>
            </div>
        </div>

        {{-- User menu --}}
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                <div class="bg-primary text-primary-content rounded-full w-8 h-8 flex justify-center items-center ">
                    <span class="text-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
            </div>
            <ul tabindex="0"
                class="dropdown-content z-[1] menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300 mt-2">
                <li class="menu-title px-3 py-1">
                    <span class="text-sm">{{ Auth::user()->name ?? 'User' }}</span>
                    <span class="text-xs text-base-content/50">{{ Auth::user()->email ?? '' }}</span>
                </li>
                <li><a href="{{ route('admin.profile.index') }}">Profile</a></li>
                <li><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                <div class="divider my-1"></div>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>