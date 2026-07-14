@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1 font-medium">Here's what's happening with your platform today.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-lg text-sm text-gray-700 font-medium shadow-sm border border-gray-200">
                    <i class="fas fa-calendar-alt text-gray-500"></i>
                    {{ Carbon\Carbon::now()->format('l, F d, Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Cars -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-base-content/60 font-medium">Total Cars</p>
                    <p class="font-display text-3xl font-bold text-base-content mt-1">{{ number_format($stats['total_cars']) }}</p>
                    <p class="text-xs text-base-content/40 mt-1">
                        <span class="text-success font-medium">↑ 12%</span> from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <i class="fas fa-car text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex gap-2 flex-wrap">
                @foreach($stats['car_statuses'] as $status => $count)
                    <span class="text-xs px-2 py-1 rounded-full bg-base-200 text-base-content/70 font-medium">
                        {{ ucfirst($status) }}: {{ $count }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Total Houses -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-base-content/60 font-medium">Total Houses</p>
                    <p class="font-display text-3xl font-bold text-base-content mt-1">{{ number_format($stats['total_houses']) }}</p>
                    <p class="text-xs text-base-content/40 mt-1">
                        <span class="text-success font-medium">↑ 8%</span> from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center text-success">
                    <i class="fas fa-house text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex gap-2 flex-wrap">
                @foreach($stats['house_statuses'] as $status => $count)
                    <span class="text-xs px-2 py-1 rounded-full bg-base-200 text-base-content/70 font-medium">
                        {{ ucfirst($status) }}: {{ $count }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Total Events -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-base-content/60 font-medium">Total Events</p>
                    <p class="font-display text-3xl font-bold text-base-content mt-1">{{ number_format($stats['total_events']) }}</p>
                    <p class="text-xs text-base-content/40 mt-1">
                        <span class="text-warning font-medium">↑ 5%</span> from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-accent">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-3 flex gap-2 flex-wrap">
                @foreach($stats['event_statuses'] as $status => $count)
                    <span class="text-xs px-2 py-1 rounded-full bg-base-200 text-base-content/70 font-medium">
                        {{ ucfirst($status) }}: {{ $count }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-base-content/60 font-medium">Total Users</p>
                    <p class="font-display text-3xl font-bold text-base-content mt-1">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-base-content/40 mt-1">
                        <span class="text-success font-medium">↑ 3%</span> from last month
                    </p>
                </div>
                <div class="w-12 h-12 bg-info/10 rounded-xl flex items-center justify-center text-info">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            @if(isset($topUser) && $topUser)
                <div class="mt-3 text-xs text-base-content/60">
                    Top Lister: <span class="font-medium text-base-content">{{ $topUser->name }}</span>
                    <span class="text-base-content/40">
                        ({{ ($topUser->cars_count ?? 0) + ($topUser->houses_count ?? 0) + ($topUser->events_count ?? 0) }} listings)
                    </span>
                </div>
            @else
                <div class="mt-3 text-xs text-base-content/40">
                    No listings yet
                </div>
            @endif
        </div>
    </div>

    {{-- Charts & Featured --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Monthly Chart --}}
        <div class="lg:col-span-2 bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-display text-lg font-semibold text-base-content">Monthly Activity</h3>
                <span class="text-xs text-base-content/40 font-medium">Last 6 months</span>
            </div>
            <div class="h-64">
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="flex justify-center gap-6 mt-4 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-primary"></span>
                    <span class="text-base-content/70 font-medium">Cars</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-success"></span>
                    <span class="text-base-content/70 font-medium">Houses</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-accent"></span>
                    <span class="text-base-content/70 font-medium">Events</span>
                </div>
            </div>
        </div>

        {{-- Featured Items --}}
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="font-display text-lg font-semibold text-base-content mb-4">Featured Items</h3>
            <div class="space-y-4">
                @if($featuredCars->isNotEmpty())
                    <div>
                        <p class="text-xs font-semibold text-primary uppercase tracking-wider mb-2">Cars</p>
                        @foreach($featuredCars as $car)
                            <div class="flex items-center gap-2 py-1">
                                <i class="fas fa-star text-accent text-xs"></i>
                                <span class="text-sm text-base-content/80 font-medium truncate">{{ $car->title }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($featuredHouses->isNotEmpty())
                    <div>
                        <p class="text-xs font-semibold text-success uppercase tracking-wider mb-2">Houses</p>
                        @foreach($featuredHouses as $house)
                            <div class="flex items-center gap-2 py-1">
                                <i class="fas fa-star text-accent text-xs"></i>
                                <span class="text-sm text-base-content/80 font-medium truncate">{{ $house->title }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($featuredEvents->isNotEmpty())
                    <div>
                        <p class="text-xs font-semibold text-accent uppercase tracking-wider mb-2">Events</p>
                        @foreach($featuredEvents as $event)
                            <div class="flex items-center gap-2 py-1">
                                <i class="fas fa-star text-accent text-xs"></i>
                                <span class="text-sm text-base-content/80 font-medium truncate">{{ $event->title }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($featuredCars->isEmpty() && $featuredHouses->isEmpty() && $featuredEvents->isEmpty())
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No featured items yet.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Cars -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Recent Cars</h3>
                <a href="{{ route('admin.cars.index') }}" class="text-xs text-primary hover:underline font-medium">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentCars as $car)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $car->title }}</p>
                            <p class="text-xs text-base-content/40">{{ $car->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.cars.show', $car) }}" class="text-base-content/30 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No cars yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Houses -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Recent Houses</h3>
                <a href="{{ route('admin.houses.index') }}" class="text-xs text-primary hover:underline font-medium">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentHouses as $house)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center text-success flex-shrink-0">
                            <i class="fas fa-house"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $house->title }}</p>
                            <p class="text-xs text-base-content/40">{{ $house->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.houses.show', $house) }}" class="text-base-content/30 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No houses yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Events -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Recent Events</h3>
                <a href="{{ route('admin.events.index') }}" class="text-xs text-primary hover:underline font-medium">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentEvents as $event)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center text-accent flex-shrink-0">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $event->title }}</p>
                            <p class="text-xs text-base-content/40">{{ $event->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.events.show', $event) }}" class="text-base-content/30 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No events yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Top Viewed --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Viewed Cars -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Top Viewed Cars</h3>
                <span class="text-xs text-base-content/40 font-medium">By views</span>
            </div>
            <div class="space-y-3">
                @forelse($topViewedCars as $car)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-primary w-5">{{ $loop->iteration }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $car->title }}</p>
                        </div>
                        <span class="text-xs text-base-content/50 font-medium">{{ number_format($car->views_count) }} views</span>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No data yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Top Viewed Houses -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Top Viewed Houses</h3>
                <span class="text-xs text-base-content/40 font-medium">By views</span>
            </div>
            <div class="space-y-3">
                @forelse($topViewedHouses as $house)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-success w-5">{{ $loop->iteration }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $house->title }}</p>
                        </div>
                        <span class="text-xs text-base-content/50 font-medium">{{ number_format($house->views_count) }} views</span>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No data yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Top Viewed Events -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-sm font-semibold text-base-content">Top Viewed Events</h3>
                <span class="text-xs text-base-content/40 font-medium">By views</span>
            </div>
            <div class="space-y-3">
                @forelse($topViewedEvents as $event)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-accent w-5">{{ $loop->iteration }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">{{ $event->title }}</p>
                        </div>
                        <span class="text-xs text-base-content/50 font-medium">{{ number_format($event->views_count) }} views</span>
                    </div>
                @empty
                    <p class="text-sm text-base-content/40 text-center py-4 font-medium">No data yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($monthlyStats['months']),
            datasets: [
                {
                    label: 'Cars',
                    data: @json($monthlyStats['cars']),
                    backgroundColor: 'rgba(26, 43, 60, 0.7)',
                    borderColor: '#1A2B3C',
                    borderWidth: 2,
                    borderRadius: 4,
                },
                {
                    label: 'Houses',
                    data: @json($monthlyStats['houses']),
                    backgroundColor: 'rgba(39, 174, 96, 0.7)',
                    borderColor: '#27AE60',
                    borderWidth: 2,
                    borderRadius: 4,
                },
                {
                    label: 'Events',
                    data: @json($monthlyStats['events']),
                    backgroundColor: 'rgba(230, 126, 34, 0.7)',
                    borderColor: '#E67E22',
                    borderWidth: 2,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 11,
                            family: 'Inter, system-ui, sans-serif',
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)',
                    }
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font: {
                            size: 11,
                            family: 'Inter, system-ui, sans-serif',
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endpush
@endsection