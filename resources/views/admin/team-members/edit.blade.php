@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
        <a href="{{ route('admin.team-members.index') }}" class="text-sm text-primary hover:underline inline-flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Back to Team
        </a>
        <h1 class="font-display text-3xl font-semibold mt-2">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Update team member information.</p>
    </div>
    <div class="flex items-center gap-2">
        <span class="badge badge-soft {{ $member->is_active ? 'badge-success' : 'badge-error' }}">
            {{ $member->is_active ? 'Active' : 'Inactive' }}
        </span>
        @if($member->is_featured)
            <span class="badge badge-soft badge-accent">
                <i class="fas fa-star mr-1"></i> Featured
            </span>
        @endif
    </div>
</div>

<!-- MAIN UPDATE FORM -->
<form method="POST" action="{{ route('admin.team-members.update', $member) }}" enctype="multipart/form-data" id="updateForm">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Information --}}
            <x-ui.card title="Basic Information">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="label"><span class="label-text">Full Name</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $member->name) }}" 
                            class="input input-bordered w-full @error('name') input-error @enderror" 
                            required
                        >
                        @error('name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="position" class="label"><span class="label-text">Position</span></label>
                            <input 
                                type="text" 
                                id="position" 
                                name="position" 
                                value="{{ old('position', $member->position) }}" 
                                class="input input-bordered w-full" 
                                placeholder="e.g. CEO & Founder"
                            >
                        </div>
                        <div>
                            <label for="department" class="label"><span class="label-text">Department</span></label>
                            <input 
                                type="text" 
                                id="department" 
                                name="department" 
                                value="{{ old('department', $member->department) }}" 
                                class="input input-bordered w-full" 
                                placeholder="e.g. Executive"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="short_bio" class="label"><span class="label-text">Short Bio</span></label>
                        <input 
                            type="text" 
                            id="short_bio" 
                            name="short_bio" 
                            value="{{ old('short_bio', $member->short_bio) }}" 
                            class="input input-bordered w-full" 
                            placeholder="Brief summary (max 500 chars)"
                        >
                        @error('short_bio') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bio" class="label"><span class="label-text">Full Bio</span></label>
                        <textarea 
                            id="bio" 
                            name="bio" 
                            rows="5" 
                            class="textarea textarea-bordered w-full @error('bio') textarea-error @enderror" 
                            placeholder="Detailed biography..."
                        >{{ old('bio', $member->bio) }}</textarea>
                        @error('bio') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- Contact & Professional Details --}}
            <x-ui.card title="Contact & Professional Details">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="label"><span class="label-text">Email</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $member->email) }}" 
                            class="input input-bordered w-full @error('email') input-error @enderror"
                        >
                        @error('email') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="label"><span class="label-text">Phone</span></label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $member->phone) }}" 
                            class="input input-bordered w-full"
                        >
                    </div>
                    <div>
                        <label for="experience" class="label"><span class="label-text">Experience</span></label>
                        <input 
                            type="text" 
                            id="experience" 
                            name="experience" 
                            value="{{ old('experience', $member->experience) }}" 
                            class="input input-bordered w-full" 
                            placeholder="e.g. 10+ years"
                        >
                    </div>
                    <div>
                        <label for="education" class="label"><span class="label-text">Education</span></label>
                        <input 
                            type="text" 
                            id="education" 
                            name="education" 
                            value="{{ old('education', $member->education) }}" 
                            class="input input-bordered w-full" 
                            placeholder="e.g. MBA, University of Rwanda"
                        >
                    </div>
                </div>
            </x-ui.card>

            {{-- Skills --}}
            <x-ui.card title="Skills">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                        $skillOptions = ['leadership', 'strategic_planning', 'client_relations', 'operations', 'logistics', 'team_management', 'event_planning', 'decor', 'vendor_management', 'property_management', 'negotiation', 'fleet_management', 'customer_service', 'marketing', 'content_creation', 'social_media'];
                        $selectedSkills = old('skills', $member->skills ?? []);
                    @endphp
                    @foreach($skillOptions as $skill)
                        <label class="flex items-center gap-2 cursor-pointer text-sm">
                            <input 
                                type="checkbox" 
                                name="skills[]" 
                                value="{{ $skill }}" 
                                class="checkbox checkbox-sm checkbox-primary" 
                                @checked(in_array($skill, $selectedSkills))
                            >
                            <span>{{ ucfirst(str_replace('_', ' ', $skill)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('skills') <p class="text-xs text-error mt-2">{{ $message }}</p> @enderror
                @error('skills.*') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
            </x-ui.card>
        </div>

        <div class="space-y-6">
            {{-- Profile Photo --}}
            <x-ui.card title="Profile Photo">
                @if($member->image)
                    <div class="mb-4">
                        <p class="text-xs text-base-content/40 mb-2">Current Photo</p>
                        <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-base-300">
                            <img src="{{ $member->image }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="label"><span class="label-text">Upload New Photo</span></label>
                    <input 
                        type="file" 
                        name="image" 
                        id="imageInput"
                        accept="image/*" 
                        class="file-input file-input-bordered file-input-sm w-full @error('image') file-input-error @enderror"
                    >
                    <p class="text-xs text-base-content/50 mt-1">Max 4MB. Recommended: Square image.</p>
                    @error('image') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Preview for new image -->
                <div id="imagePreviewContainer" class="mt-4 hidden">
                    <p class="text-xs text-base-content/40 mb-2">New Photo Preview</p>
                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-base-300">
                        <img id="imagePreview" src="#" alt="Preview" class="w-full h-full object-cover">
                    </div>
                </div>
            </x-ui.card>

            {{-- Visibility --}}
            <x-ui.card title="Visibility">
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <span class="text-sm font-medium">Active</span>
                        <p class="text-xs text-base-content/50">Show on the website</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        class="toggle toggle-primary" 
                        @checked(old('is_active', $member->is_active))
                    >
                </label>

                <label class="flex items-center justify-between cursor-pointer mt-3">
                    <div>
                        <span class="text-sm font-medium">Featured</span>
                        <p class="text-xs text-base-content/50">Highlight on the team page</p>
                    </div>
                    <input 
                        type="checkbox" 
                        name="is_featured" 
                        value="1" 
                        class="toggle toggle-accent" 
                        @checked(old('is_featured', $member->is_featured))
                    >
                </label>

                <div class="mt-3">
                    <label for="order" class="label"><span class="label-text">Display Order</span></label>
                    <input 
                        type="number" 
                        id="order" 
                        name="order" 
                        value="{{ old('order', $member->order ?? 0) }}" 
                        class="input input-bordered w-full" 
                        min="0"
                    >
                </div>
            </x-ui.card>

            {{-- Actions --}}
            <x-ui.card>
                <button type="submit" class="btn btn-primary w-full" form="updateForm">
                    <i class="fas fa-save mr-2"></i> Update Team Member
                </button>
                <a href="{{ route('admin.team-members.index') }}" class="btn btn-ghost w-full mt-2">Cancel</a>
            </x-ui.card>
        </div>
    </div>
</form>

<!-- DELETE FORM - Separated and clearly marked -->
<div class="mt-6 pt-6 border-t border-base-300">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm text-base-content/60">Danger Zone</p>
            <p class="text-xs text-base-content/40">Once you delete a team member, there is no going back.</p>
        </div>
        <form id="delete-form-{{ $member->id }}" action="{{ route('admin.team-members.destroy', $member) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button 
                type="button" 
                onclick="confirmDelete('{{ $member->id }}', '{{ $member->name }}')" 
                class="btn btn-error"
            >
                <i class="fas fa-trash mr-2"></i> Delete Team Member
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`⚠️ Are you sure you want to delete "${name}"?\n\nThis action cannot be undone.`)) {
        document.getElementById(`delete-form-${id}`).submit();
    }
}

// Preview image before upload
document.getElementById('imageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImage = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            previewImage.src = ev.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
        previewImage.src = '#';
    }
});
</script>
@endpush
@endsection