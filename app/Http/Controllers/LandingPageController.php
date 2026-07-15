<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Event;
use App\Models\House;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Show the landing page with real data from database.
     */
    public function index(): View
    {
        // Get featured items
        $featuredCars = Car::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        $featuredHouses = House::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        $featuredEvents = Event::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        // Get statistics
        $totalCars = Car::count();
        $totalHouses = House::count();
        $totalEvents = Event::count();
        $totalClients = $totalCars + $totalHouses + $totalEvents; // Approximate

        // Get recent/testimonial data (using available listings as testimonials)
        $testimonials = $this->getTestimonials();

        // Get gallery images (using cover images from listings)
        $galleryImages = $this->getGalleryImages();

        return view('landing-page', [
            'pageTitle' => 'ME FOR YOU - Your Professional Companion',
            'transparentNav' => true,
            'featuredCars' => $featuredCars,
            'featuredHouses' => $featuredHouses,
            'featuredEvents' => $featuredEvents,
            'stats' => [
                'clients' => $totalClients,
                'properties' => $totalHouses,
                'events' => $totalEvents,
                'rating' => '5★',
            ],
            'testimonials' => $testimonials,
            'galleryImages' => $galleryImages,
        ]);
    }

    /**
     * Get testimonial data from various sources.
     */
    private function getTestimonials(): array
    {
        // You can use actual reviews table if you have one
        // For now, using sample data with some real data from database
        $recentHouses = House::latest()->take(1)->first();
        $recentCars = Car::latest()->take(1)->first();
        $recentEvents = Event::latest()->take(1)->first();

        $testimonials = [];

        if ($recentHouses) {
            $testimonials[] = [
                'name' => 'Amina K.',
                'role' => 'Housing Client, Kigali',
                'quote' => "ME FOR YOU found us the perfect apartment in Kigali within a week. The whole process was smooth, transparent, and stress-free. Highly recommended!",
                'stars' => 5,
                'avatar' => 'assets/testimonials/client-01.webp',
            ];
        }

        if ($recentEvents) {
            $testimonials[] = [
                'name' => 'Jean-Pierre & Grace M.',
                'role' => 'Wedding Clients',
                'quote' => "Our wedding was absolutely magical. The décor, coordination, and transport everything was handled perfectly. Thank you ME FOR YOU!",
                'stars' => 5,
                'avatar' => 'assets/testimonials/client-02.webp',
            ];
        }

        if ($recentCars) {
            $testimonials[] = [
                'name' => 'David N.',
                'role' => 'Corporate Client, Kigali',
                'quote' => "We used ME FOR YOU for our company's annual conference transport. Professional drivers, clean vehicles, and always on time. Outstanding service.",
                'stars' => 5,
                'avatar' => 'assets/testimonials/client-03.webp',
            ];
        }

        return $testimonials;
    }

    /**
     * Get gallery images from database listings.
     */
    private function getGalleryImages(): array
    {
        $images = [];

        // Get event images
        $events = Event::whereNotNull('cover_image')
            ->latest()
            ->take(3)
            ->get();

        foreach ($events as $event) {
            $images[] = [
                'src' => $event->cover_image,
                'alt' => $event->title,
                'label' => ucfirst($event->category),
            ];
        }

        // Get house images
        $houses = House::whereNotNull('cover_image')
            ->latest()
            ->take(2)
            ->get();

        foreach ($houses as $house) {
            $images[] = [
                'src' => $house->cover_image,
                'alt' => $house->title,
                'label' => 'Housing',
            ];
        }

        // Get car images
        $cars = Car::whereNotNull('cover_image')
            ->latest()
            ->take(1)
            ->get();

        foreach ($cars as $car) {
            $images[] = [
                'src' => $car->cover_image,
                'alt' => $car->title,
                'label' => 'Transport',
            ];
        }

        // If no images found, use fallback
        if (empty($images)) {
            $images = [
                ['src' => asset('assets/gallery/wedding-01.webp'), 'alt' => 'Wedding Ceremony', 'label' => 'Wedding'],
                ['src' => asset('assets/gallery/corporate-01.webp'), 'alt' => 'Corporate Event', 'label' => 'Corporate Event'],
                ['src' => asset('assets/gallery/house-02.webp'), 'alt' => 'Property Listing', 'label' => 'Housing'],
                ['src' => asset('assets/gallery/event-decor-01.webp'), 'alt' => 'Event Decoration', 'label' => 'Event Décor'],
                ['src' => asset('assets/transport/hero-car.webp'), 'alt' => 'Fleet Vehicle', 'label' => 'Transport'],
            ];
        }

        return $images;
    }
}