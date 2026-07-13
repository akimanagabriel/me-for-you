<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\HouseImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HouseController extends Controller
{
    private const TYPES = ['apartment', 'villa', 'townhouse', 'studio', 'bungalow'];
    private const STATUSES = ['available', 'rented', 'unavailable'];
    private const PRICE_PERIODS = ['month', 'day', 'night'];
    private const AMENITIES = ['wifi', 'parking', 'pool', 'gym', 'security', 'generator', 'water_tank', 'garden', 'balcony', 'air_conditioning'];

    public function index(Request $request): View
    {
        $houses = House::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('location', 'like', '%' . $request->search . '%')
                        ->orWhere('city', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status))
            ->when($request->filled('type'), fn($query) => $query->where('type', $request->type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.houses.index', [
            'pageTitle' => 'Houses',
            'breadcrumbs' => [['label' => 'Houses']],
            'houses' => $houses,
            'filters' => $request->only(['search', 'status', 'type']),
        ]);
    }

    public function create(): View
    {
        return view('admin.houses.create', [
            'pageTitle' => 'Add House',
            'breadcrumbs' => [['label' => 'Houses', 'url' => route('admin.houses.index')], ['label' => 'Add New']],
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
            'pricePeriods' => self::PRICE_PERIODS,
            'amenitiesOptions' => self::AMENITIES,
            'house' => new House(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $house = DB::transaction(function () use ($data, $request) {
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['amenities'] = $data['amenities'] ?? [];
            $data['user_id'] = auth()->id();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('houses/covers', 'public')
                );
            }

            $house = House::create($data);
            $this->storeGalleryImages($house, $request);

            return $house;
        });

        return redirect()
            ->route('admin.houses.show', $house)
            ->with('success', "\"{$house->title}\" was created successfully.");
    }

    public function show(House $house): View
    {
        $house->load('images');

        return view('admin.houses.show', [
            'pageTitle' => $house->title,
            'breadcrumbs' => [['label' => 'Houses', 'url' => route('admin.houses.index')], ['label' => $house->title]],
            'house' => $house,
        ]);
    }

    public function edit(House $house): View
    {
        $house->load('images');

        return view('admin.houses.edit', [
            'pageTitle' => 'Edit House',
            'breadcrumbs' => [['label' => 'Houses', 'url' => route('admin.houses.index')], ['label' => 'Edit']],
            'types' => self::TYPES,
            'statuses' => self::STATUSES,
            'pricePeriods' => self::PRICE_PERIODS,
            'amenitiesOptions' => self::AMENITIES,
            'house' => $house,
        ]);
    }

    public function update(Request $request, House $house): RedirectResponse
    {
        $data = $this->validated($request, $house);

        DB::transaction(function () use ($data, $request, $house) {
            $data['amenities'] = $data['amenities'] ?? [];

            if ($data['title'] !== $house->title) {
                $data['slug'] = $this->uniqueSlug($data['title'], $house->id);
            }

            if ($request->hasFile('cover_image')) {
                $this->deletePublicFile($house->cover_image);
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('houses/covers', 'public')
                );
            }

            $house->update($data);
            $this->storeGalleryImages($house, $request);

            if ($request->filled('remove_images')) {
                $this->removeGalleryImages($house, $request->input('remove_images'));
            }
        });

        return redirect()
            ->route('admin.houses.show', $house)
            ->with('success', "\"{$house->title}\" was updated successfully.");
    }

    public function destroy(House $house): RedirectResponse
    {
        DB::transaction(function () use ($house) {
            $this->deletePublicFile($house->cover_image);

            foreach ($house->images as $image) {
                $this->deletePublicFile($image->image_path);
            }

            $house->delete();
        });

        return redirect()
            ->route('admin.houses.index')
            ->with('success', "\"{$house->title}\" was deleted.");
    }

    private function validated(Request $request, ?House $house = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string', 'in:' . implode(',', self::TYPES)],
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'price_period' => ['required', 'string', 'in:' . implode(',', self::PRICE_PERIODS)],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:255'],
            'size_sqm' => ['nullable', 'integer', 'min:0'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'in:' . implode(',', self::AMENITIES)],
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
            House::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$suffix;
        }

        return $slug;
    }

    private function storeGalleryImages(House $house, Request $request): void
    {
        if (!$request->hasFile('gallery')) {
            return;
        }

        $nextOrder = $house->images()->max('sort_order') + 1;
        $hasCover = $house->images()->where('is_cover', true)->exists();

        foreach ($request->file('gallery') as $index => $file) {
            $path = Storage::disk('public')->url($file->store('houses/gallery', 'public'));

            $house->images()->create([
                'image_path' => $path,
                'alt_text' => $house->title,
                'is_cover' => !$hasCover && $index === 0,
                'sort_order' => $nextOrder + $index,
            ]);
        }
    }

    private function removeGalleryImages(House $house, array $imageIds): void
    {
        $images = $house->images()->whereIn('id', $imageIds)->get();

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
}