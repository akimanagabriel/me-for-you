<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of team members with filters.
     */
    public function index(Request $request): View
    {
        $query = TeamMember::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('short_bio', 'like', "%{$search}%");
            });
        }

        // Status filter (active/inactive)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured == '1');
        }

        // Order by the 'order' column, then by name
        $members = $query->orderBy('order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString(); // Preserve query parameters in pagination links

        return view('admin.team-members.index', [
            'pageTitle' => 'Team Members',
            'breadcrumbs' => [['label' => 'Team Members']],
            'members' => $members,
        ]);
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create(): View
    {
        return view('admin.team-members.create', [
            'pageTitle' => 'Add Team Member',
            'breadcrumbs' => [
                ['label' => 'Team Members', 'url' => route('admin.team-members.index')],
                ['label' => 'Add New']
            ],
            'member' => new TeamMember(),
        ]);
    }

    /**
     * Store a newly created team member in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data, $request) {
            $data['slug'] = $this->uniqueSlug($data['name']);
            $data['skills'] = $data['skills'] ?? [];
            $data['user_id'] = auth()->id();

            if ($request->hasFile('image')) {
                $data['image'] = Storage::disk('public')->url(
                    $request->file('image')->store('team', 'public')
                );
            }

            TeamMember::create($data);
        });

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member added successfully.');
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(TeamMember $teamMember): View
    {
        return view('admin.team-members.edit', [
            'pageTitle' => 'Edit Team Member',
            'breadcrumbs' => [
                ['label' => 'Team Members', 'url' => route('admin.team-members.index')],
                ['label' => 'Edit']
            ],
            'member' => $teamMember,
        ]);
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, TeamMember $teamMember): RedirectResponse
    {
        $data = $this->validated($request, $teamMember);

        DB::transaction(function () use ($data, $request, $teamMember) {
            $data['skills'] = $data['skills'] ?? [];

            if ($data['name'] !== $teamMember->name) {
                $data['slug'] = $this->uniqueSlug($data['name'], $teamMember->id);
            }

            if ($request->hasFile('image')) {
                $this->deleteFile($teamMember->image);
                $data['image'] = Storage::disk('public')->url(
                    $request->file('image')->store('team', 'public')
                );
            }

            $teamMember->update($data);
        });

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified team member from storage.
     */
    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        DB::transaction(function () use ($teamMember) {
            $this->deleteFile($teamMember->image);
            $teamMember->delete();
        });

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member deleted successfully.');
    }

    /**
     * Validate the request data.
     */
    private function validated(Request $request, ?TeamMember $member = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'short_bio' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'experience' => ['nullable', 'string', 'max:100'],
            'education' => ['nullable', 'string'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    /**
     * Generate a unique slug for the team member.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (
            TeamMember::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$suffix;
        }

        return $slug;
    }

    /**
     * Delete a file from storage.
     */
    private function deleteFile(?string $url): void
    {
        if (!$url || !str_starts_with($url, Storage::disk('public')->url(''))) {
            return;
        }

        $path = Str::after($url, Storage::disk('public')->url(''));
        Storage::disk('public')->delete($path);
    }

    public function toggleActive(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->update(['is_active' => !$teamMember->is_active]);

        $status = $teamMember->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Team member {$status} successfully.");
    }

    /**
     * Toggle the featured status of a team member.
     */
    public function toggleFeatured(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->update(['is_featured' => !$teamMember->is_featured]);

        $status = $teamMember->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Team member {$status} successfully.");
    }
}