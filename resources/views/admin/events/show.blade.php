@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.events.index') }}" class="text-sm text-primary hover:underline">&larr; Back to Events</a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $event->title }}</h1>
        <div class="flex items-center gap-3 mt-1">
            <span class="badge badge-soft 
                @switch($event->status)
                    @case('active') badge-success @break
                    @case('draft') badge-ghost @break
                    @case('completed') badge-info @break
                    @case('cancelled') badge-error @break
                    @case('postponed') badge-warning @break
                    @default badge-ghost
                @endswitch">
                {{ ucfirst($event->status) }}
            </span>
            <span class="badge badge-soft badge-primary">{{ ucfirst($event->category) }}</span>
            @if($event->is_featured)
                <span class="badge badge-soft badge-accent">
                    <i class="fas fa-star mr-1"></i> Featured
                </span>
            @endif
        </div>
    </div>
    
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-pen mr-2"></i> Edit Event
        </a>
        <button onclick="confirmDelete('{{ $event->id }}', '{{ $event->title }}')" class="btn btn-error btn-sm">
            <i class="fas fa-trash mr-2"></i> Delete
        </button>
        <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Cover Image -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 overflow-hidden">
            @if($event->cover_image)
                <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" class="w-full h-80 object-cover">
            @else
                <div class="w-full h-80 bg-base-200 flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-calendar-alt text-6xl text-base-content/20"></i>
                        <p class="text-base-content/40 mt-2">No cover image</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Description -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4">About This Event</h3>
            @if($event->description)
                <div class="prose prose-sm max-w-none">
                    {!! nl2br(e($event->description)) !!}
                </div>
            @else
                <p class="text-base-content/40">No description provided.</p>
            @endif
        </div>

        <!-- Features & Requirements -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($event->features && count($event->features) > 0)
                <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">
                        <i class="fas fa-star text-accent mr-2"></i> Features
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($event->features as $feature)
                            <span class="badge badge-soft badge-primary">
                                {{ ucfirst(str_replace('_', ' ', $feature)) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($event->requirements && count($event->requirements) > 0)
                <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                    <h3 class="text-lg font-semibold text-base-content mb-4">
                        <i class="fas fa-clipboard-list text-warning mr-2"></i> Requirements
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($event->requirements as $requirement)
                            <span class="badge badge-soft badge-warning">
                                {{ ucfirst(str_replace('_', ' ', $requirement)) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Gallery -->
        @if($event->images && $event->images->count() > 0)
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4">
                    <i class="fas fa-images text-primary mr-2"></i> Gallery
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($event->images as $image)
                        <div class="relative group rounded-lg overflow-hidden aspect-square bg-base-200">
                            <img src="{{ $image->image_path }}" alt="{{ $image->alt_text ?? $event->title }}" class="w-full h-full object-cover">
                            @if($image->is_cover)
                                <div class="absolute top-2 left-2">
                                    <span class="badge badge-soft badge-accent badge-sm">Cover</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ $image->image_path }}" target="_blank" class="btn btn-ghost btn-sm text-white">
                                    <i class="fas fa-expand"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Event Details -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4">Event Details</h3>
            
            <div class="space-y-3">
                <!-- Date -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary flex-shrink-0 mt-0.5">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <p class="text-xs text-base-content/40 font-medium">Date</p>
                        <p class="text-sm font-medium">{{ $event->event_date->format('l, F d, Y') }}</p>
                    </div>
                </div>

                <!-- Time -->
                @if($event->start_time)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-accent/10 rounded-lg flex items-center justify-center text-accent flex-shrink-0 mt-0.5">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/40 font-medium">Time</p>
                            <p class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                @if($event->end_time)
                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Location -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-info/10 rounded-lg flex items-center justify-center text-info flex-shrink-0 mt-0.5">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="text-xs text-base-content/40 font-medium">Location</p>
                        <p class="text-sm font-medium">{{ $event->location }}</p>
                        <p class="text-xs text-base-content/60">{{ $event->city }}</p>
                        @if($event->venue)
                            <p class="text-xs text-base-content/60">{{ $event->venue }}</p>
                        @endif
                        @if($event->address)
                            <p class="text-xs text-base-content/40">{{ $event->address }}</p>
                        @endif
                    </div>
                </div>

                <!-- Pricing -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-success/10 rounded-lg flex items-center justify-center text-success flex-shrink-0 mt-0.5">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div>
                        <p class="text-xs text-base-content/40 font-medium">Pricing</p>
                        @if($event->price)
                            <p class="text-sm font-semibold text-base-content">
                                {{ number_format($event->price, 0, ',', ',') }} {{ $event->currency }}
                                @if($event->price_period !== 'total')
                                    <span class="text-xs text-base-content/60 font-normal">/ {{ str_replace('_', ' ', $event->price_period) }}</span>
                                @endif
                            </p>
                        @else
                            <p class="text-sm font-medium text-success">Free Event</p>
                        @endif
                    </div>
                </div>

                <!-- Views -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-base-200 rounded-lg flex items-center justify-center text-base-content/40 flex-shrink-0 mt-0.5">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div>
                        <p class="text-xs text-base-content/40 font-medium">Views</p>
                        <p class="text-sm font-medium">{{ number_format($event->views_count) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Speaker & Host -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4">Speaker & Host</h3>
            
            <div class="space-y-3">
                @if($event->speaker)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary flex-shrink-0 mt-0.5">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/40 font-medium">Speaker</p>
                            <p class="text-sm font-medium">{{ $event->speaker }}</p>
                        </div>
                    </div>
                @endif

                @if($event->host)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary flex-shrink-0 mt-0.5">
                            <i class="fas fa-microphone"></i>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/40 font-medium">Host</p>
                            <p class="text-sm font-medium">{{ $event->host }}</p>
                        </div>
                    </div>
                @endif

                @if($event->organizer)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-secondary/10 rounded-lg flex items-center justify-center text-secondary flex-shrink-0 mt-0.5">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/40 font-medium">Organizer</p>
                            <p class="text-sm font-medium">{{ $event->organizer }}</p>
                        </div>
                    </div>
                @endif

                @if(!$event->speaker && !$event->host && !$event->organizer)
                    <p class="text-sm text-base-content/40">No speaker or host information provided.</p>
                @endif
            </div>
        </div>

        <!-- Contact -->
        @if($event->contact_email || $event->contact_phone)
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4">Contact Information</h3>
                
                <div class="space-y-3">
                    @if($event->contact_email)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary flex-shrink-0 mt-0.5">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/40 font-medium">Email</p>
                                <a href="mailto:{{ $event->contact_email }}" class="text-sm font-medium text-primary hover:underline">
                                    {{ $event->contact_email }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($event->contact_phone)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary flex-shrink-0 mt-0.5">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <p class="text-xs text-base-content/40 font-medium">Phone</p>
                                <a href="tel:{{ $event->contact_phone }}" class="text-sm font-medium text-primary hover:underline">
                                    {{ $event->contact_phone }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Created By -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4">Listing Information</h3>
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-base-content/60">Created</span>
                    <span class="font-medium">{{ $event->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-base-content/60">Last Updated</span>
                    <span class="font-medium">{{ $event->updated_at->format('M d, Y h:i A') }}</span>
                </div>
                @if($event->owner)
                    <div class="flex justify-between">
                        <span class="text-base-content/60">Created By</span>
                        <span class="font-medium">{{ $event->owner->name }}</span>
                    </div>
                @endif
                @if($event->deleted_at)
                    <div class="flex justify-between text-error">
                        <span class="text-base-content/60">Deleted</span>
                        <span class="font-medium">{{ $event->deleted_at->format('M d, Y h:i A') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

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