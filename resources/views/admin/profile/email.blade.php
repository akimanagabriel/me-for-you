@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.profile.index') }}" class="text-sm text-primary hover:underline inline-flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Back to Profile
        </a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Update your email address.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('admin.profile.email.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <i class="fas fa-envelope text-info"></i> Change Email Address
                </h3>

                <div class="space-y-4">
                    {{-- Current Email (Read-only) --}}
                    <div>
                        <label class="label">
                            <span class="label-text">Current Email Address</span>
                        </label>
                        <div class="input input-bordered w-full bg-base-200/50 cursor-not-allowed text-base-content/60 flex items-center">
                            <i class="fas fa-envelope text-base-content/30 mr-2"></i>
                            {{ $user->email }}
                        </div>
                    </div>

                    {{-- New Email --}}
                    <div>
                        <label for="email" class="label">
                            <span class="label-text">New Email Address</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            placeholder="Enter your new email address"
                            required
                            autocomplete="email"
                        />
                        @error('email')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm with Password --}}
                    <div>
                        <label for="current_password" class="label">
                            <span class="label-text">Confirm with Password</span>
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="input input-bordered w-full @error('current_password') input-error @enderror"
                            placeholder="Enter your current password to confirm"
                            required
                            autocomplete="current-password"
                        />
                        @error('current_password')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="fas fa-save mr-2"></i> Update Email
                        </button>
                        <a href="{{ route('admin.profile.index') }}" class="btn btn-ghost flex-1">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Email Info --}}
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-sm font-semibold text-base-content/60 uppercase tracking-wider mb-4">
                <i class="fas fa-info-circle text-info mr-2"></i> Email Information
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <div>
                        <p class="text-base-content/60">Current Email</p>
                        <p class="font-medium text-base-content">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <div>
                        <p class="text-base-content/60">Member Since</p>
                        <p class="font-medium text-base-content">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-sm font-semibold text-base-content/60 uppercase tracking-wider mb-4">Quick Links</h3>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-base-200 transition-colors text-base-content">
                    <i class="fas fa-tachometer-alt w-5 text-success"></i>
                    <span class="text-sm">Dashboard</span>
                    <i class="fas fa-chevron-right ml-auto text-xs text-base-content/30"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Show/hide password toggle
document.querySelectorAll('input[type="password"]').forEach(input => {
    const wrapper = document.createElement('div');
    wrapper.style.position = 'relative';
    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);

    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content/60 transition-colors';
    toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
    toggleBtn.setAttribute('aria-label', 'Toggle password visibility');
    wrapper.appendChild(toggleBtn);
    
    toggleBtn.addEventListener('click', function() {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
});
</script>
@endpush
@endsection