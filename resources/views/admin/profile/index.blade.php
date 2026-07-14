@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">View and manage your profile information.</p>
    </div>
    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-pen mr-2"></i> Edit Profile
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 overflow-hidden">
            <div class="relative">
                <!-- Cover/Banner -->
                <div class="h-24 bg-gradient-to-r from-primary/20 to-accent/20"></div>
                
                <!-- Avatar -->
                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full border-4 border-base-100 overflow-hidden bg-base-200">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-primary/10 text-primary text-3xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('admin.profile.edit') }}" class="absolute bottom-0 right-0 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white hover:bg-primary/90 transition-colors shadow-lg">
                            <i class="fas fa-camera text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="pt-14 px-6 pb-6 text-center">
                <h2 class="text-xl font-bold text-base-content">{{ $user->name }}</h2>
                <p class="text-sm text-base-content/60">{{ $user->email }}</p>
                
                @if($user->email_verified_at)
                    <span class="inline-flex items-center gap-1 mt-2 text-xs text-success">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 mt-2 text-xs text-warning">
                        <i class="fas fa-exclamation-circle"></i> Unverified
                    </span>
                @endif

                <div class="mt-4 pt-4 border-t border-base-200">
                    <div class="flex justify-around">
                        <div>
                            <p class="text-2xl font-bold text-base-content">{{ $user->created_at->format('Y') }}</p>
                            <p class="text-xs text-base-content/40">Joined</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-base-content">
                                {{ \App\Models\Car::where('user_id', $user->id)->count() + \App\Models\House::where('user_id', $user->id)->count() + \App\Models\Event::where('user_id', $user->id)->count() }}
                            </p>
                            <p class="text-xs text-base-content/40">Listings</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-base-content">{{ $user->email_verified_at ? 'Active' : 'Pending' }}</p>
                            <p class="text-xs text-base-content/40">Status</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6 mt-6">
            <h3 class="text-sm font-semibold text-base-content/60 uppercase tracking-wider mb-4">Quick Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-base-200 transition-colors text-base-content">
                    <i class="fas fa-user-edit w-5 text-primary"></i>
                    <span class="text-sm">Edit Profile</span>
                    <i class="fas fa-chevron-right ml-auto text-xs text-base-content/30"></i>
                </a>
                <a href="{{ route('admin.profile.password') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-base-200 transition-colors text-base-content">
                    <i class="fas fa-key w-5 text-accent"></i>
                    <span class="text-sm">Change Password</span>
                    <i class="fas fa-chevron-right ml-auto text-xs text-base-content/30"></i>
                </a>
                <a href="{{ route('admin.profile.email') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-base-200 transition-colors text-base-content">
                    <i class="fas fa-envelope w-5 text-info"></i>
                    <span class="text-sm">Change Email</span>
                    <i class="fas fa-chevron-right ml-auto text-xs text-base-content/30"></i>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-base-200 transition-colors text-base-content">
                    <i class="fas fa-tachometer-alt w-5 text-success"></i>
                    <span class="text-sm">Dashboard</span>
                    <i class="fas fa-chevron-right ml-auto text-xs text-base-content/30"></i>
                </a>
                <div class="border-t border-base-200 pt-2 mt-1">
                    <button onclick="confirmDeleteAccount()" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-error/10 transition-colors text-error w-full">
                        <i class="fas fa-trash-alt w-5"></i>
                        <span class="text-sm">Delete Account</span>
                        <i class="fas fa-chevron-right ml-auto text-xs text-error/30"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Personal Information -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                <i class="fas fa-user text-primary"></i> Personal Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Full Name</p>
                    <p class="text-sm font-medium text-base-content">{{ $user->name }}</p>
                </div>
                
                <div class="space-y-1">
                    <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Email Address</p>
                    <p class="text-sm font-medium text-base-content">{{ $user->email }}</p>
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 text-xs text-success">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs text-warning">
                            <i class="fas fa-exclamation-circle"></i> Not verified
                        </span>
                    @endif
                </div>
                
                @if($user->phone)
                    <div class="space-y-1">
                        <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Phone Number</p>
                        <p class="text-sm font-medium text-base-content">{{ $user->phone }}</p>
                    </div>
                @endif
                
                <div class="space-y-1">
                    <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Member Since</p>
                    <p class="text-sm font-medium text-base-content">{{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>

            @if($user->bio)
                <div class="mt-4 pt-4 border-t border-base-200">
                    <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider mb-1">Bio</p>
                    <p class="text-sm text-base-content/80">{{ $user->bio }}</p>
                </div>
            @endif
        </div>

        <!-- Recent Activity -->
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-accent"></i> Recent Activity
            </h3>
            
            <div class="space-y-3">
                @php
                    $recentCars = \App\Models\Car::where('user_id', $user->id)->latest()->take(3)->get();
                    $recentHouses = \App\Models\House::where('user_id', $user->id)->latest()->take(3)->get();
                    $recentEvents = \App\Models\Event::where('user_id', $user->id)->latest()->take(3)->get();
                    $allRecent = collect()
                        ->merge($recentCars->map(fn($item) => ['type' => 'Car', 'title' => $item->title, 'url' => route('admin.cars.show', $item), 'created' => $item->created_at]))
                        ->merge($recentHouses->map(fn($item) => ['type' => 'House', 'title' => $item->title, 'url' => route('admin.houses.show', $item), 'created' => $item->created_at]))
                        ->merge($recentEvents->map(fn($item) => ['type' => 'Event', 'title' => $item->title, 'url' => route('admin.events.show', $item), 'created' => $item->created_at]))
                        ->sortByDesc('created')
                        ->take(5);
                @endphp

                @forelse($allRecent as $activity)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-base-200 transition-colors">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                            @switch($activity['type'])
                                @case('Car') bg-primary/10 text-primary @break
                                @case('House') bg-success/10 text-success @break
                                @case('Event') bg-accent/10 text-accent @break
                                @default bg-base-200 text-base-content/40
                            @endswitch">
                            <i class="fas 
                                @switch($activity['type'])
                                    @case('Car') fa-car @break
                                    @case('House') fa-house @break
                                    @case('Event') fa-calendar-alt @break
                                    @default fa-circle
                                @endswitch"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-base-content truncate">
                                <a href="{{ $activity['url'] }}" class="hover:text-primary transition-colors">
                                    {{ $activity['title'] }}
                                </a>
                            </p>
                            <p class="text-xs text-base-content/40">
                                {{ $activity['type'] }} • {{ $activity['created']->diffForHumans() }}
                            </p>
                        </div>
                        <a href="{{ $activity['url'] }}" class="text-base-content/30 hover:text-primary transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6">
                        <div class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-inbox text-xl text-base-content/30"></i>
                        </div>
                        <p class="text-sm text-base-content/40">No recent activity found.</p>
                        <p class="text-xs text-base-content/30 mt-1">Start creating listings to see activity here.</p>
                    </div>
                @endforelse
            </div>

            @if($allRecent->isNotEmpty())
                <div class="mt-4 pt-4 border-t border-base-200">
                    <a href="#" class="text-sm text-primary hover:underline">View all activity →</a>
                </div>
            @endif
        </div>

        <!-- Account Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-4 text-center">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-car text-primary"></i>
                </div>
                <p class="text-2xl font-bold text-base-content">{{ \App\Models\Car::where('user_id', $user->id)->count() }}</p>
                <p class="text-xs text-base-content/40">Cars Listed</p>
            </div>
            
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-4 text-center">
                <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-house text-success"></i>
                </div>
                <p class="text-2xl font-bold text-base-content">{{ \App\Models\House::where('user_id', $user->id)->count() }}</p>
                <p class="text-xs text-base-content/40">Houses Listed</p>
            </div>
            
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-4 text-center">
                <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-calendar-alt text-accent"></i>
                </div>
                <p class="text-2xl font-bold text-base-content">{{ \App\Models\Event::where('user_id', $user->id)->count() }}</p>
                <p class="text-xs text-base-content/40">Events Created</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-base-100 rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <div class="text-center">
            <div class="w-16 h-16 rounded-full bg-error/10 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-error"></i>
            </div>
            <h3 class="text-lg font-semibold text-base-content mb-2">Delete Account</h3>
            <p class="text-sm text-base-content/60 mb-6">
                Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.
            </p>
            
            <form action="{{ route('admin.profile.delete') }}" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')
                
                <div>
                    <label for="delete_password" class="label text-sm font-medium text-base-content/60">Confirm your password</label>
                    <input type="password" id="delete_password" name="password" class="input input-bordered w-full @error('password') input-error @enderror" placeholder="Enter your password" required>
                    @error('password')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-ghost flex-1">Cancel</button>
                    <button type="submit" class="btn btn-error flex-1">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDeleteAccount() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endpush
@endsection