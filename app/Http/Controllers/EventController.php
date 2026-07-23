<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    private const CATEGORIES = ['conference', 'wedding', 'corporate', 'private', 'concert', 'exhibition', 'party', 'workshop', 'seminar'];
    private const STATUSES = ['draft', 'active', 'completed', 'cancelled', 'postponed'];
    private const PRICE_PERIODS = ['total', 'per_person', 'per_hour'];
    private const FEATURES = ['catering', 'audio_visual', 'parking', 'security', 'wifi', 'photography', 'videography', 'decorations', 'live_music', 'dj', 'bar_service', 'catering', 'tents', 'lighting', 'stage'];
    private const REQUIREMENTS = ['dress_code', 'age_restriction', 'registration_required', 'id_required', 'invitation_only', 'vaccination_required'];

    public function index(Request $request): View
    {
        $events = Event::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('location', 'like', '%' . $request->search . '%')
                        ->orWhere('venue', 'like', '%' . $request->search . '%')
                        ->orWhere('speaker', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status))
            ->when($request->filled('category'), fn($query) => $query->where('category', $request->category))
            ->when($request->filled('city'), fn($query) => $query->where('city', $request->city))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.events.index', [
            'pageTitle' => 'Events',
            'breadcrumbs' => [['label' => 'Events']],
            'events' => $events,
            'filters' => $request->only(['search', 'status', 'category', 'city']),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'pageTitle' => 'Add Event',
            'breadcrumbs' => [
                ['label' => 'Events', 'url' => route('admin.events.index')],
                ['label' => 'Add New']
            ],
            'categories' => self::CATEGORIES,
            'statuses' => self::STATUSES,
            'pricePeriods' => self::PRICE_PERIODS,
            'featuresOptions' => self::FEATURES,
            'requirementsOptions' => self::REQUIREMENTS,
            'event' => new Event(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $event = DB::transaction(function () use ($data, $request) {
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['features'] = $data['features'] ?? [];
            $data['requirements'] = $data['requirements'] ?? [];
            $data['user_id'] = auth()->id();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('events/covers', 'public')
                );
            }

            $event = Event::create($data);
            $this->storeGalleryImages($event, $request);

            return $event;
        });

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', "\"{$event->title}\" was created successfully.");
    }

    public function show(Event $event): View
    {
        $event->load('images');

        return view('admin.events.show', [
            'pageTitle' => $event->title,
            'breadcrumbs' => [
                ['label' => 'Events', 'url' => route('admin.events.index')],
                ['label' => $event->title]
            ],
            'event' => $event,
        ]);
    }

    public function edit(Event $event): View
    {
        $event->load('images');

        return view('admin.events.edit', [
            'pageTitle' => 'Edit Event',
            'breadcrumbs' => [
                ['label' => 'Events', 'url' => route('admin.events.index')],
                ['label' => 'Edit']
            ],
            'categories' => self::CATEGORIES,
            'statuses' => self::STATUSES,
            'pricePeriods' => self::PRICE_PERIODS,
            'featuresOptions' => self::FEATURES,
            'requirementsOptions' => self::REQUIREMENTS,
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validated($request, $event);

        DB::transaction(function () use ($data, $request, $event) {
            $data['features'] = $data['features'] ?? [];
            $data['requirements'] = $data['requirements'] ?? [];

            if ($data['title'] !== $event->title) {
                $data['slug'] = $this->uniqueSlug($data['title'], $event->id);
            }

            if ($request->hasFile('cover_image')) {
                $this->deletePublicFile($event->cover_image);
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('events/covers', 'public')
                );
            }

            $event->update($data);
            $this->storeGalleryImages($event, $request);

            if ($request->filled('remove_images')) {
                $this->removeGalleryImages($event, $request->input('remove_images'));
            }
        });

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', "\"{$event->title}\" was updated successfully.");
    }

    public function destroy(Event $event): RedirectResponse
    {
        DB::transaction(function () use ($event) {
            $this->deletePublicFile($event->cover_image);

            foreach ($event->images as $image) {
                $this->deletePublicFile($image->image_path);
            }

            $event->delete();
        });

        return redirect()
            ->route('admin.events.index')
            ->with('success', "\"{$event->title}\" was deleted.");
    }

    private function validated(Request $request, ?Event $event = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'in:' . implode(',', self::CATEGORIES)],
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'venue' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'price_period' => ['required', 'string', 'in:' . implode(',', self::PRICE_PERIODS)],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'in:' . implode(',', self::FEATURES)],
            'requirements' => ['nullable', 'array'],
            'requirements.*' => ['string', 'in:' . implode(',', self::REQUIREMENTS)],
            'speaker' => ['nullable', 'string', 'max:255'],
            'host' => ['nullable', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'gallery.*' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (
            Event::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$suffix;
        }

        return $slug;
    }

    private function storeGalleryImages(Event $event, Request $request): void
    {
        if (!$request->hasFile('gallery')) {
            return;
        }

        $nextOrder = $event->images()->max('sort_order') + 1;
        $hasCover = $event->images()->where('is_cover', true)->exists();

        foreach ($request->file('gallery') as $index => $file) {
            $path = Storage::disk('public')->url($file->store('events/gallery', 'public'));

            $event->images()->create([
                'image_path' => $path,
                'alt_text' => $event->title,
                'is_cover' => !$hasCover && $index === 0,
                'sort_order' => $nextOrder + $index,
            ]);
        }
    }

    private function removeGalleryImages(Event $event, array $imageIds): void
    {
        $images = $event->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            $this->deletePublicFile($image->image_path);
            $image->delete();
        }
    }

    private function deletePublicFile(?string $url): void
    {
        if (!$url || !str_starts_with($url, Storage::disk('public')->url(''))) {
            return;
        }

        $path = Str::after($url, Storage::disk('public')->url(''));
        Storage::disk('public')->delete($path);
    }


    public function toggleFeatured(Event $event): RedirectResponse
    {
        $event->update(['is_featured' => !$event->is_featured]);

        $status = $event->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Event {$status} successfully.");
    }
}