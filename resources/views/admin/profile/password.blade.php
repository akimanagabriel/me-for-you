@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.profile.index') }}" class="text-sm text-primary hover:underline inline-flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Back to Profile
        </a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Update your account password.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('admin.profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <i class="fas fa-key text-accent"></i> Change Password
                </h3>

                <div class="space-y-4">
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="label">
                            <span class="label-text">Current Password</span>
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="input input-bordered w-full @error('current_password') input-error @enderror"
                            placeholder="Enter your current password"
                            required
                            autocomplete="current-password"
                        />
                        @error('current_password')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="label">
                            <span class="label-text">New Password</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="input input-bordered w-full @error('password') input-error @enderror"
                            placeholder="Enter your new password"
                            required
                            autocomplete="new-password"
                        />
                        @error('password')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div>
                        <label for="password_confirmation" class="label">
                            <span class="label-text">Confirm New Password</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="input input-bordered w-full"
                            placeholder="Confirm your new password"
                            required
                            autocomplete="new-password"
                        />
                    </div>

                    {{-- Password Requirements --}}
                    <div class="bg-base-200/50 rounded-lg p-4 mt-4">
                        <p class="text-xs font-semibold text-base-content/60 uppercase tracking-wider mb-2">Password Requirements</p>
                        <ul class="space-y-1 text-sm text-base-content/60">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-success text-xs"></i>
                                Minimum 8 characters
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-success text-xs"></i>
                                Must contain at least one uppercase letter
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-success text-xs"></i>
                                Must contain at least one lowercase letter
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-success text-xs"></i>
                                Must contain at least one number
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check-circle text-success text-xs"></i>
                                Must contain at least one special character
                            </li>
                        </ul>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit" class="btn btn-primary flex-1">
                            <i class="fas fa-save mr-2"></i> Update Password
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
        {{-- Security Tips --}}
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
            <h3 class="text-sm font-semibold text-base-content/60 uppercase tracking-wider mb-4">
                <i class="fas fa-shield-alt text-primary mr-2"></i> Security Tips
            </h3>
            <div class="space-y-3 text-sm text-base-content/60">
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <p>Use a unique password that you don't use elsewhere.</p>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <p>Make your password at least 12 characters long for better security.</p>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <p>Enable two-factor authentication if available.</p>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-success text-xs mt-0.5"></i>
                    <p>Never share your password with anyone.</p>
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
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Show password toggle functionality (optional)
document.querySelectorAll('input[type="password"]').forEach(input => {
    // Add toggle button for each password field
    const wrapper = input.parentElement;
    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-base-content/40 hover:text-base-content/60 transition-colors';
    toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
    toggleBtn.setAttribute('aria-label', 'Toggle password visibility');
    
    // Style the wrapper for relative positioning
    wrapper.style.position = 'relative';
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