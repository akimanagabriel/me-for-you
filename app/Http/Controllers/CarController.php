<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CarController extends Controller
{
    private const BODY_TYPES = ['sedan', 'suv', 'hatchback', 'coupe', 'pickup', 'van', 'convertible'];
    private const STATUSES = ['available', 'reserved', 'sold', 'unavailable'];
    private const CONDITIONS = ['new', 'used', 'certified_pre_owned'];
    private const FUEL_TYPES = ['petrol', 'diesel', 'hybrid', 'electric'];
    private const TRANSMISSIONS = ['automatic', 'manual'];
    private const PRICE_PERIODS = ['total', 'day', 'month'];
    private const FEATURES = [
        'ac',
        'bluetooth',
        'sunroof',
        'backup_camera',
        'leather_seats',
        'navigation',
        'cruise_control',
        'heated_seats',
        'keyless_entry',
        'parking_sensors',
        'alloy_wheels',
        'third_row_seats',
    ];

    public function index(Request $request): View
    {
        $cars = Car::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('make', 'like', '%' . $request->search . '%')
                        ->orWhere('model', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status))
            ->when($request->filled('body_type'), fn($query) => $query->where('body_type', $request->body_type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.cars.index', [
            'pageTitle' => 'Cars',
            'breadcrumbs' => [['label' => 'Cars']],
            'cars' => $cars,
            'filters' => $request->only(['search', 'status', 'body_type']),
        ]);
    }

    public function create(): View
    {
        return view('admin.cars.create', [
            'pageTitle' => 'Add Car',
            'breadcrumbs' => [['label' => 'Cars', 'url' => route('admin.cars.index')], ['label' => 'Add New']],
            'bodyTypes' => self::BODY_TYPES,
            'statuses' => self::STATUSES,
            'conditions' => self::CONDITIONS,
            'fuelTypes' => self::FUEL_TYPES,
            'transmissions' => self::TRANSMISSIONS,
            'pricePeriods' => self::PRICE_PERIODS,
            'featuresOptions' => self::FEATURES,
            'car' => new Car(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $car = DB::transaction(function () use ($data, $request) {
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['features'] = $data['features'] ?? [];
            $data['user_id'] = auth()->id();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('cars/covers', 'public')
                );
            }

            $car = Car::create($data);
            $this->storeGalleryImages($car, $request);

            return $car;
        });

        return redirect()
            ->route('admin.cars.show', $car)
            ->with('success', "\"{$car->title}\" was created successfully.");
    }

    public function show(Car $car): View
    {
        $car->load('images');

        return view('admin.cars.show', [
            'pageTitle' => $car->title,
            'breadcrumbs' => [['label' => 'Cars', 'url' => route('admin.cars.index')], ['label' => $car->title]],
            'car' => $car,
        ]);
    }

    public function edit(Car $car): View
    {
        $car->load('images');

        return view('admin.cars.edit', [
            'pageTitle' => 'Edit Car',
            'breadcrumbs' => [['label' => 'Cars', 'url' => route('admin.cars.index')], ['label' => 'Edit']],
            'bodyTypes' => self::BODY_TYPES,
            'statuses' => self::STATUSES,
            'conditions' => self::CONDITIONS,
            'fuelTypes' => self::FUEL_TYPES,
            'transmissions' => self::TRANSMISSIONS,
            'pricePeriods' => self::PRICE_PERIODS,
            'featuresOptions' => self::FEATURES,
            'car' => $car,
        ]);
    }

    public function update(Request $request, Car $car): RedirectResponse
    {
        $data = $this->validated($request, $car);

        DB::transaction(function () use ($data, $request, $car) {
            $data['features'] = $data['features'] ?? [];

            if ($data['title'] !== $car->title) {
                $data['slug'] = $this->uniqueSlug($data['title'], $car->id);
            }

            if ($request->hasFile('cover_image')) {
                $this->deletePublicFile($car->cover_image);
                $data['cover_image'] = Storage::disk('public')->url(
                    $request->file('cover_image')->store('cars/covers', 'public')
                );
            }

            $car->update($data);
            $this->storeGalleryImages($car, $request);

            if ($request->filled('remove_images')) {
                $this->removeGalleryImages($car, $request->input('remove_images'));
            }
        });

        return redirect()
            ->route('admin.cars.show', $car)
            ->with('success', "\"{$car->title}\" was updated successfully.");
    }

    public function destroy(Car $car): RedirectResponse
    {
        DB::transaction(function () use ($car) {
            $this->deletePublicFile($car->cover_image);

            foreach ($car->images as $image) {
                $this->deletePublicFile($image->image_path);
            }

            $car->delete();
        });

        return redirect()
            ->route('admin.cars.index')
            ->with('success', "\"{$car->title}\" was deleted.");
    }

    private function validated(Request $request, ?Car $car = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'vin' => [
                'nullable',
                'string',
                'max:32',
                'unique:cars,vin' . ($car ? ',' . $car->id : ''),
            ],
            'color' => ['nullable', 'string', 'max:255'],
            'body_type' => ['required', 'string', 'in:' . implode(',', self::BODY_TYPES)],
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
            'condition' => ['required', 'string', 'in:' . implode(',', self::CONDITIONS)],
            'fuel_type' => ['required', 'string', 'in:' . implode(',', self::FUEL_TYPES)],
            'transmission' => ['required', 'string', 'in:' . implode(',', self::TRANSMISSIONS)],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'price_period' => ['required', 'string', 'in:' . implode(',', self::PRICE_PERIODS)],
            'mileage' => ['required', 'integer', 'min:0'],
            'engine_capacity' => ['nullable', 'numeric', 'min:0', 'max:99.9'],
            'seats' => ['required', 'integer', 'min:1', 'max:50'],
            'doors' => ['required', 'integer', 'min:1', 'max:10'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'in:' . implode(',', self::FEATURES)],
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
            Car::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$suffix;
        }

        return $slug;
    }

    private function storeGalleryImages(Car $car, Request $request): void
    {
        if (!$request->hasFile('gallery')) {
            return;
        }

        $nextOrder = $car->images()->max('sort_order') + 1;
        $hasCover = $car->images()->where('is_cover', true)->exists();

        foreach ($request->file('gallery') as $index => $file) {
            $path = Storage::disk('public')->url($file->store('cars/gallery', 'public'));

            $car->images()->create([
                'image_path' => $path,
                'alt_text' => $car->title,
                'is_cover' => !$hasCover && $index === 0,
                'sort_order' => $nextOrder + $index,
            ]);
        }
    }

    private function removeGalleryImages(Car $car, array $imageIds): void
    {
        $images = $car->images()->whereIn('id', $imageIds)->get();

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