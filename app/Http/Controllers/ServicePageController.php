<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Event;
use App\Models\House;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    /**
     * Show the events service page.
     */
    public function events(): View
    {
        $featuredEvents = Event::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        $upcomingEvents = Event::where('status', 'active')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        $pastEvents = Event::where('status', 'completed')
            ->orderBy('event_date', 'desc')
            ->take(6)
            ->get();

        $stats = [
            'total' => Event::count(),
            'upcoming' => Event::where('status', 'active')->where('event_date', '>=', now())->count(),
            'completed' => Event::where('status', 'completed')->count(),
            'categories' => Event::select('category')->distinct()->count(),
        ];

        return view('public.services.events', [
            'pageTitle' => 'Event Management Services',
            'featuredEvents' => $featuredEvents,
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the housing service page.
     */
    public function housing(): View
    {
        $featuredHouses = House::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $availableHouses = House::where('status', 'available')
            ->latest()
            ->paginate(9);

        $rentedHouses = House::where('status', 'rented')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total' => House::count(),
            'available' => House::where('status', 'available')->count(),
            'rented' => House::where('status', 'rented')->count(),
            'cities' => House::select('city')->distinct()->count(),
        ];

        return view('public.services.housing', [
            'pageTitle' => 'Housing Services',
            'featuredHouses' => $featuredHouses,
            'availableHouses' => $availableHouses,
            'rentedHouses' => $rentedHouses,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the transport (cars) service page.
     */
    public function transport(): View
    {
        $featuredCars = Car::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $availableCars = Car::where('status', 'available')
            ->latest()
            ->paginate(9);

        $reservedCars = Car::where('status', 'reserved')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total' => Car::count(),
            'available' => Car::where('status', 'available')->count(),
            'reserved' => Car::where('status', 'reserved')->count(),
            'types' => Car::select('body_type')->distinct()->count(),
        ];

        return view('public.services.transport', [
            'pageTitle' => 'Transport Services',
            'featuredCars' => $featuredCars,
            'availableCars' => $availableCars,
            'reservedCars' => $reservedCars,
            'stats' => $stats,
        ]);
    }

    /**
     * Show a single event detail.
     */
    public function eventShow(string $slug): View
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Increment view count
        $event->increment('views_count');

        $relatedEvents = Event::where('id', '!=', $event->id)
            ->where('category', $event->category)
            ->whereIn('status', ['active', 'completed'])
            ->latest()
            ->take(4)
            ->get();

        return view('public.services.event-detail', [
            'pageTitle' => $event->title,
            'event' => $event,
            'relatedEvents' => $relatedEvents,
        ]);
    }

    /**
     * Show a single house detail.
     */
    public function houseShow(string $slug): View
    {
        $house = House::where('slug', $slug)->firstOrFail();

        // Increment view count
        $house->increment('views_count');

        $relatedHouses = House::where('id', '!=', $house->id)
            ->where('city', $house->city)
            ->where('status', 'available')
            ->latest()
            ->take(4)
            ->get();

        return view('public.services.house-detail', [
            'pageTitle' => $house->title,
            'house' => $house,
            'relatedHouses' => $relatedHouses,
        ]);
    }

    /**
     * Show a single car detail.
     */
    public function carShow(string $slug): View
    {
        $car = Car::where('slug', $slug)->firstOrFail();

        // Increment view count
        $car->increment('views_count');

        $relatedCars = Car::where('id', '!=', $car->id)
            ->where('make', $car->make)
            ->where('status', 'available')
            ->latest()
            ->take(4)
            ->get();

        return view('public.services.car-detail', [
            'pageTitle' => $car->title,
            'car' => $car,
            'relatedCars' => $relatedCars,
        ]);
    }
}