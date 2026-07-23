@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Manage all your events in one place.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus-circle mr-2"></i> Add New Event
    </a>
</div>

<!-- Filters -->
<div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[180px]">
            <input 
                type="text" 
                name="search" 
                placeholder="Search events..." 
                value="{{ request('search') }}" 
                class="input input-bordered input-sm w-full"
            >
        </div>
        <div class="w-[140px]">
            <select name="status" class="select select-bordered select-sm w-full">
                <option value="">All Statuses</option>
                @foreach(['draft', 'active', 'completed', 'cancelled', 'postponed'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-[140px]">
            <select name="category" class="select select-bordered select-sm w-full">
                <option value="">All Categories</option>
                @foreach(['conference', 'wedding', 'corporate', 'private', 'concert', 'exhibition', 'party', 'workshop', 'seminar'] as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ ucfirst($category) }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-search mr-1"></i> Filter
        </button>
        @if(request()->hasAny(['search', 'status', 'category']))
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">Clear</a>
        @endif
    </form>
</div>

<!-- Events Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
        <div class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col relative">
            <!-- Image -->
            <div class="relative h-48 bg-gray-100 flex-shrink-0">
                @if($event->cover_image)
                    <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <i class="fa-solid fa-calendar-days text-5xl"></i>
                    </div>
                @endif
                
                <!-- Status Badge (left) -->
                <div class="absolute top-3 left-3 z-10">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @switch($event->status)
                            @case('active') bg-green-100 text-green-800 @break
                            @case('draft') bg-gray-100 text-gray-800 @break
                            @case('completed') bg-blue-100 text-blue-800 @break
                            @case('cancelled') bg-red-100 text-red-800 @break
                            @case('postponed') bg-yellow-100 text-yellow-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <!-- Featured Toggle (right) - Always clickable -->
                <div class="absolute top-3 right-3 z-20 pointer-events-auto">
                    <div class="flex items-center gap-2 bg-white/90 px-2 py-1 rounded-full shadow-sm">
                        <span class="text-xs text-gray-500 font-medium">Featured</span>
                        <form method="POST" action="{{ route('admin.events.toggle-featured', $event) }}" 
                              class="inline-flex items-center" 
                              id="toggle-featured-form-{{ $event->id }}">
                            @csrf
                            @method('PUT')
                            <label class="cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    class="toggle toggle-sm toggle-accent" 
                                    {{ $event->is_featured ? 'checked' : '' }}
                                    onchange="document.getElementById('toggle-featured-form-{{ $event->id }}').submit();"
                                    title="{{ $event->is_featured ? 'Click to unfeature' : 'Click to feature' }}"
                                >
                            </label>
                        </form>
                    </div>
                </div>

                <!-- Overlay with Action Buttons (hover) -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 pointer-events-none group-hover:pointer-events-auto">
                    <a href="{{ route('admin.events.show', $event) }}" 
                       class="transform -translate-y-2 group-hover:translate-y-0 transition-all duration-300 inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 shadow-lg">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" 
                       class="transform -translate-y-2 group-hover:translate-y-0 transition-all duration-300 delay-75 inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 shadow-lg">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <button onclick="confirmDelete('{{ $event->id }}', '{{ $event->title }}')" 
                            class="transform -translate-y-2 group-hover:translate-y-0 transition-all duration-300 delay-150 inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 shadow-lg">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    <form id="delete-form-{{ $event->id }}" 
                          action="{{ route('admin.events.destroy', $event) }}" 
                          method="POST" 
                          class="hidden">
                        @csrf 
                        @method('DELETE')
                    </form>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-4 flex-1 flex flex-col">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="font-semibold text-gray-900 line-clamp-1 flex-1">{{ $event->title }}</h3>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 flex-shrink-0 ml-2">
                        {{ ucfirst($event->category) }}
                    </span>
                </div>
                
                <div class="space-y-1 text-sm text-gray-600 flex-1">
                    <div>
                        <i class="fa-regular fa-calendar-day w-4 text-gray-400"></i>
                        {{ $event->event_date->format('M d, Y') }}
                        @if($event->start_time)
                            <span class="text-xs text-gray-500">
                                at {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <i class="fa-solid fa-location-dot w-4 text-gray-400"></i>
                        {{ $event->location }}, {{ $event->city }}
                    </div>
                    @if($event->venue)
                        <div>
                            <i class="fa-regular fa-building w-4 text-gray-400"></i>
                            {{ $event->venue }}
                        </div>
                    @endif
                    @if($event->speaker)
                        <div>
                            <i class="fa-regular fa-user w-4 text-gray-400"></i>
                            {{ $event->speaker }}
                        </div>
                    @endif
                </div>
                
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            @if($event->price)
                                <span class="font-semibold text-gray-900">{{ number_format($event->price, 0, ',', ',') }}</span>
                                <span class="text-xs text-gray-500">{{ $event->currency }}</span>
                                @if($event->price_period !== 'total')
                                    <span class="text-xs text-gray-400">/{{ str_replace('_', ' ', $event->price_period) }}</span>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">Free</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">
                                <i class="fa-regular fa-eye mr-1"></i> {{ number_format($event->views_count) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-calendar-days text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No events found</h3>
                <p class="text-sm text-gray-500 mt-1">Get started by creating your first event.</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm mt-4">
                    <i class="fa-solid fa-plus-circle mr-2"></i> Add New Event
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($events->hasPages())
    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endif

<style>
/* Smooth hover transitions */
.group {
    transition: all 0.3s ease;
}
.group:hover {
    transform: translateY(-4px);
}

/* Ensure overlay covers the image properly */
.group .absolute.inset-0 {
    border-radius: 0;
}

/* Button animations */
.group .transform {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Toggle switch styling (fallback for DaisyUI) */
.toggle {
    --tglbg: #d1d5db;
    appearance: none;
    -webkit-appearance: none;
    background-color: var(--tglbg);
    cursor: pointer;
    display: inline-block;
    height: 1.25rem;
    width: 2.25rem;
    border-radius: 9999px;
    transition: all 0.15s ease-in-out;
    position: relative;
    flex-shrink: 0;
    border: 1px solid #d1d5db;
}
.toggle:checked {
    --tglbg: #b87f3a;
    border-color: #b87f3a;
}
.toggle:checked.toggle-accent {
    --tglbg: #b87f3a;
    border-color: #b87f3a;
}
.toggle:focus-visible {
    outline: 2px solid #b87f3a;
    outline-offset: 2px;
}
.toggle-sm:before {
    content: "";
    display: block;
    width: 0.875rem;
    height: 0.875rem;
    background-color: #ffffff;
    border-radius: 9999px;
    transition: all 0.15s ease-in-out;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transform: translateX(0.125rem);
}
.toggle-sm:checked:before {
    transform: translateX(1rem);
}
.toggle-sm:checked.toggle-accent:before {
    background-color: #ffffff;
}

/* Responsive adjustments for the toggle */
@media (max-width: 480px) {
    .absolute.top-3.right-3 .toggle-sm {
        height: 1rem;
        width: 1.8rem;
    }
    .absolute.top-3.right-3 .toggle-sm:before {
        width: 0.7rem;
        height: 0.7rem;
    }
    .absolute.top-3.right-3 .toggle-sm:checked:before {
        transform: translateX(0.8rem);
    }
    .absolute.top-3.right-3 .flex.items-center.gap-2 {
        padding: 0.25rem 0.5rem;
        font-size: 0.65rem;
    }
}
</style>

@push('scripts')
<script>
function confirmDelete(id, title) {
    if (confirm(`Are you sure you want to delete "${title}"? This action cannot be undone.`)) {
        document.getElementById(`delete-form-${id}`).submit();
    }
}
</script>
@endpush
@endsection