<?php

namespace App\Http\Controllers;

class PublicPageController extends Controller
{
    public function houses()
    {
        return view('public.houses.index', [
            'pageTitle' => 'Housing Services',
            'houses' => $this->sampleHouses(),
        ]);
    }

    public function houseShow(string $slug)
    {
        $house = collect($this->sampleHouses())->firstWhere('slug', $slug);

        abort_unless($house, 404);

        return view('public.houses.show', [
            'pageTitle' => $house['title'],
            'house' => $house,
        ]);
    }

    public function cars()
    {
        return view('public.cars.index', [
            'pageTitle' => 'Transport Services',
            'cars' => $this->sampleCars(),
        ]);
    }

    public function carShow(string $slug)
    {
        $car = collect($this->sampleCars())->firstWhere('slug', $slug);

        abort_unless($car, 404);

        return view('public.cars.show', [
            'pageTitle' => $car['title'],
            'car' => $car,
        ]);
    }

    public function events()
    {
        return view('public.events.index', [
            'pageTitle' => 'Event Management',
            'events' => $this->sampleEvents(),
        ]);
    }

    public function eventShow(string $slug)
    {
        $event = collect($this->sampleEvents())->firstWhere('slug', $slug);

        abort_unless($event, 404);

        return view('public.events.show', [
            'pageTitle' => $event['title'],
            'event' => $event,
        ]);
    }

    public function about()
    {
        return view('public.about', ['pageTitle' => 'About Us']);
    }

    public function contact()
    {
        return view('public.contact', ['pageTitle' => 'Contact Us']);
    }

    public function gallery()
    {
        return view('public.gallery', ['pageTitle' => 'Our Work']);
    }

    public function faq()
    {
        return view('public.faq', [
            'pageTitle' => 'Frequently Asked Questions',
            'faqs' => $this->sampleFaqs(),
        ]);
    }

    private function sampleHouses(): array
    {
        return [
            ['slug' => 'kigali-heights-apartment', 'title' => 'Kigali Heights Apartment', 'location' => 'Kacyiru, Kigali', 'price' => 'RWF 450,000/mo', 'beds' => 3, 'baths' => 2, 'type' => 'Apartment', 'image' => 'assets/housing/property-01.webp', 'status' => 'available'],
            ['slug' => 'nyarutarama-villa', 'title' => 'Nyarutarama Villa', 'location' => 'Nyarutarama, Kigali', 'price' => 'RWF 1,200,000/mo', 'beds' => 5, 'baths' => 4, 'type' => 'Villa', 'image' => 'assets/housing/hero-house.webp', 'status' => 'available'],
            ['slug' => 'remera-townhouse', 'title' => 'Remera Townhouse', 'location' => 'Remera, Kigali', 'price' => 'RWF 650,000/mo', 'beds' => 4, 'baths' => 3, 'type' => 'Townhouse', 'image' => 'assets/gallery/house-02.webp', 'status' => 'rented'],
        ];
    }

    private function sampleCars(): array
    {
        return [
            ['slug' => 'toyota-rav4', 'title' => 'Toyota RAV4', 'type' => 'SUV', 'price' => 'RWF 80,000/day', 'seats' => 5, 'transmission' => 'Automatic', 'image' => 'assets/transport/car-01.webp', 'status' => 'available'],
            ['slug' => 'mercedes-e-class', 'title' => 'Mercedes E-Class', 'type' => 'Sedan', 'price' => 'RWF 120,000/day', 'seats' => 5, 'transmission' => 'Automatic', 'image' => 'assets/transport/hero-car.webp', 'status' => 'available'],
            ['slug' => 'toyota-hiace', 'title' => 'Toyota Hiace', 'type' => 'Van', 'price' => 'RWF 150,000/day', 'seats' => 14, 'transmission' => 'Manual', 'image' => 'assets/transport/car-01.webp', 'status' => 'booked'],
        ];
    }

    private function sampleEvents(): array
    {
        return [
            ['slug' => 'wedding-planning', 'title' => 'Wedding Planning', 'category' => 'Weddings', 'price' => 'From RWF 2,000,000', 'image' => 'assets/events/event-01.webp', 'status' => 'active'],
            ['slug' => 'corporate-conference', 'title' => 'Corporate Conference', 'category' => 'Corporate', 'price' => 'From RWF 1,500,000', 'image' => 'assets/gallery/corporate-01.webp', 'status' => 'active'],
            ['slug' => 'private-celebration', 'title' => 'Private Celebration', 'category' => 'Private', 'price' => 'From RWF 800,000', 'image' => 'assets/gallery/event-decor-01.webp', 'status' => 'active'],
        ];
    }

    private function sampleFaqs(): array
    {
        return [
            ['question' => 'What areas do you serve?', 'answer' => 'We primarily serve Kigali and surrounding areas in Rwanda, with services available nationwide for events and transport.'],
            ['question' => 'How do I book a property viewing?', 'answer' => 'Contact us via WhatsApp or email, and our team will schedule a convenient viewing within 24–48 hours.'],
            ['question' => 'Do you offer chauffeur services?', 'answer' => 'Yes, all our vehicles can be rented with a professional chauffeur upon request.'],
            ['question' => 'What is included in event management?', 'answer' => 'Our event packages include venue coordination, décor, catering liaison, transport, and on-day management.'],
        ];
    }
}
