@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
@php
    $user = Auth::user();
@endphp

<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.profile.index') }}" class="text-sm text-primary hover:underline inline-flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Back to Profile
        </a>

        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Update your profile information.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.profile.update') }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Personal Information --}}
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-primary"></i> Personal Information
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="label"><span class="label-text">Full Name</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder="Enter your full name"
                            required
                        />
                        @error('name')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="label"><span class="label-text">Email Address</span></label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            placeholder="Enter your email address"
                            required
                        />
                        @error('email')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                        @if($user->email_verified_at)
                            <p class="text-xs text-success mt-1">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </p>
                        @else
                            <p class="text-xs text-warning mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> Not verified
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Account Information --}}
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <i class="fas fa-shield-alt text-accent"></i> Account Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Account Created</p>
                        <p class="text-sm font-medium text-base-content">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Last Updated</p>
                        <p class="text-sm font-medium text-base-content">{{ $user->updated_at->format('F d, Y') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">Status</p>
                        <p class="text-sm font-medium text-base-content">
                            @if($user->email_verified_at)
                                <span class="badge badge-soft badge-success">Active</span>
                            @else
                                <span class="badge badge-soft badge-warning">Pending Verification</span>
                            @endif
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs text-base-content/40 font-medium uppercase tracking-wider">User ID</p>
                        <p class="text-sm font-medium text-base-content">#{{ $user->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Actions --}}
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-lg font-semibold text-base-content mb-4 flex items-center gap-2">
                    <i class="fas fa-save text-success"></i> Save Changes
                </h3>
                
                <div class="flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-ghost w-full">Cancel</a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-6">
                <h3 class="text-sm font-semibold text-base-content/60 uppercase tracking-wider mb-4">Quick Links</h3>
                <div class="space-y-2">
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
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Any additional JavaScript if needed
</script>
@endpush
@endsection