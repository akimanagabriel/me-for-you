@extends('layouts.admin')

@section('title', $pageTitle)

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="font-display text-3xl font-semibold">{{ $pageTitle }}</h1>
        <p class="text-sm text-base-content/60 mt-1">Manage your team members.</p>
    </div>
    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus-circle mr-2"></i> Add Team Member
    </a>
</div>

{{-- Search & Filter Bar --}}
<div class="bg-base-100 rounded-xl shadow-sm border border-base-300 p-4 mb-6">
    <form method="GET" action="{{ route('admin.team-members.index') }}" class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px]">
            <input 
                type="text" 
                name="search" 
                placeholder="Search by name, position, department..." 
                value="{{ request('search') }}" 
                class="input input-bordered input-sm w-full"
            >
        </div>
        <div class="w-[140px]">
            <select name="status" class="select select-bordered select-sm w-full">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="w-[140px]">
            <select name="featured" class="select select-bordered select-sm w-full">
                <option value="">All</option>
                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-search mr-1"></i> Filter
        </button>
        @if(request()->hasAny(['search', 'status', 'featured']))
            <a href="{{ route('admin.team-members.index') }}" class="btn btn-ghost btn-sm">Clear</a>
        @endif
    </form>
</div>

{{-- Cards Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($members as $member)
        <div class="bg-base-100 rounded-xl shadow-sm border border-base-300 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
            {{-- Card Header with Image and Status --}}
            <div class="flex items-start gap-4 p-4 pb-2">
                <div class="w-16 h-16 rounded-full bg-base-200 flex-shrink-0 overflow-hidden border-2 border-base-300">
                    @if($member->image)
                        <img src="{{ $member->image }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-base-content/30 text-2xl font-bold">
                            {{ substr($member->name, 0, 2) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="font-display text-lg font-semibold text-base-content truncate">{{ $member->name }}</h3>
                            <p class="text-sm text-primary font-medium">{{ $member->position ?? '—' }}</p>
                        </div>
                        {{-- Status Badge --}}
                        <div class="flex-shrink-0 mt-0.5 flex items-center gap-1">
                            <span class="badge badge-soft {{ $member->is_active ? 'badge-success' : 'badge-error' }} text-xs">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($member->is_featured)
                                <span class="badge badge-soft badge-accent text-xs ml-1">
                                    <i class="fas fa-star mr-0.5"></i> Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-base-content/40 truncate">{{ $member->email ?? 'No email' }}</p>
                </div>
            </div>

            {{-- Card Body with Details --}}
            <div class="px-4 py-2 space-y-1.5 text-sm text-base-content/70 flex-1">
                @if($member->department)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-building text-base-content/30 w-4 text-center"></i>
                        <span>{{ $member->department }}</span>
                    </div>
                @endif
                @if($member->experience)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-briefcase text-base-content/30 w-4 text-center"></i>
                        <span>{{ $member->experience }}</span>
                    </div>
                @endif
                @if($member->education)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-base-content/30 w-4 text-center"></i>
                        <span class="truncate">{{ $member->education }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    <i class="fas fa-sort-numeric-up text-base-content/30 w-4 text-center"></i>
                    <span>Order: <span class="font-semibold text-base-content">{{ $member->order ?? 0 }}</span></span>
                </div>
                @if($member->short_bio)
                    <div class="mt-1 text-xs text-base-content/50 line-clamp-2">{{ $member->short_bio }}</div>
                @endif
            </div>

            {{-- Card Footer with Actions --}}
            <div class="px-4 py-3 border-t border-base-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    {{-- Toggle Active/Inactive --}}
                    <form method="POST" action="{{ route('admin.team-members.toggle', $member) }}" class="inline-flex items-center gap-2" id="toggle-form-{{ $member->id }}">
                        @csrf
                        @method('PUT')
                        <span class="text-xs text-base-content/40 {{ $member->is_active ? 'text-success' : 'text-error' }} font-medium">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <label class="cursor-pointer">
                            <input 
                                type="checkbox" 
                                class="toggle toggle-sm {{ $member->is_active ? 'toggle-success' : 'toggle-error' }}" 
                                {{ $member->is_active ? 'checked' : '' }}
                                onchange="document.getElementById('toggle-form-{{ $member->id }}').submit();"
                                title="{{ $member->is_active ? 'Click to deactivate' : 'Click to activate' }}"
                            >
                        </label>
                    </form>

                    {{-- Toggle Featured/Unfeatured --}}
                    <form method="POST" action="{{ route('admin.team-members.toggle-featured', $member) }}" class="inline-flex items-center gap-2" id="toggle-featured-form-{{ $member->id }}">
                        @csrf
                        @method('PUT')
                        <span class="text-xs text-base-content/40 {{ $member->is_featured ? 'text-accent' : '' }} font-medium">
                            <i class="fas fa-star mr-0.5"></i> Featured
                        </span>
                        <label class="cursor-pointer">
                            <input 
                                type="checkbox" 
                                class="toggle toggle-sm toggle-accent" 
                                {{ $member->is_featured ? 'checked' : '' }}
                                onchange="document.getElementById('toggle-featured-form-{{ $member->id }}').submit();"
                                title="{{ $member->is_featured ? 'Click to unfeature' : 'Click to feature' }}"
                            >
                        </label>
                    </form>
                </div>

                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.team-members.edit', $member) }}" class="btn btn-ghost btn-xs btn-square text-primary" title="Edit">
                        <i class="fas fa-pen"></i>
                    </a>
                    <button onclick="confirmDelete('{{ $member->id }}', '{{ $member->name }}')" class="btn btn-ghost btn-xs btn-square text-error" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-form-{{ $member->id }}" action="{{ route('admin.team-members.destroy', $member) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-base-content/40">
            <div class="w-20 h-20 rounded-full bg-base-200 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-3xl text-base-content/20"></i>
            </div>
            <p class="text-lg font-medium text-base-content/60">No team members found</p>
            <p class="text-sm mt-1">Get started by adding your first team member.</p>
            <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary btn-sm mt-4">
                <i class="fas fa-plus-circle mr-2"></i> Add Team Member
            </a>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($members->hasPages())
    <div class="mt-6">
        {{ $members->links() }}
    </div>
@endif

<style>
    /* Ensure toggle is visible */
    .toggle {
        --tglbg: #d1d5db;
        appearance: none;
        -webkit-appearance: none;
        background-color: var(--tglbg);
        cursor: pointer;
        display: inline-block;
        height: 1.5rem;
        width: 2.75rem;
        border-radius: 9999px;
        transition: all 0.15s ease-in-out;
        position: relative;
        flex-shrink: 0;
        border: 1px solid #d1d5db;
    }
    .toggle:checked {
        --tglbg: #10b981;
        border-color: #10b981;
    }
    .toggle.toggle-error:checked {
        --tglbg: #ef4444;
        border-color: #ef4444;
    }
    .toggle.toggle-success:checked {
        --tglbg: #10b981;
        border-color: #10b981;
    }
    .toggle:focus-visible {
        outline: 2px solid #10b981;
        outline-offset: 2px;
    }
    .toggle-sm {
        height: 1.25rem;
        width: 2.25rem;
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
    .toggle-sm:checked.toggle-error:before {
        background-color: #ffffff;
    }
    .toggle-sm:checked.toggle-success:before {
        background-color: #ffffff;
    }
    /* Toggle accent (gold) for featured */
    .toggle-accent:checked {
        --tglbg: #b87f3a;
        border-color: #b87f3a;
    }
    .toggle-accent:checked:before {
        background-color: #ffffff;
    }
</style>

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
        document.getElementById(`delete-form-${id}`).submit();
    }
}
</script>
@endpush
@endsection