<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Event;
use App\Models\House;
use App\Models\TeamMember;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    /**
     * Display the housing page with real data.
     */
    public function houses(): View
    {
        $houses = House::where('status', '!=', 'unavailable')
            ->latest()
            ->paginate(12);

        $featuredHouses = House::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total' => House::count(),
            'available' => House::where('status', 'available')->count(),
            'rented' => House::where('status', 'rented')->count(),
            'cities' => House::select('city')->distinct()->count(),
        ];

        return view('public.houses.index', [
            'pageTitle' => 'Housing Services',
            'houses' => $houses,
            'featuredHouses' => $featuredHouses,
            'stats' => $stats,
        ]);
    }

    /**
     * Display a single house detail.
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

        return view('public.houses.show', [
            'pageTitle' => $house->title,
            'house' => $house,
            'relatedHouses' => $relatedHouses,
        ]);
    }

    /**
     * Display the cars/transport page with real data.
     */
    public function cars(): View
    {
        $cars = Car::where('status', '!=', 'unavailable')
            ->latest()
            ->paginate(12);

        $featuredCars = Car::where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total' => Car::count(),
            'available' => Car::where('status', 'available')->count(),
            'reserved' => Car::where('status', 'reserved')->count(),
            'types' => Car::select('body_type')->distinct()->count(),
        ];

        return view('public.cars.index', [
            'pageTitle' => 'Transport Services',
            'cars' => $cars,
            'featuredCars' => $featuredCars,
            'stats' => $stats,
        ]);
    }

    /**
     * Display a single car detail.
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

        return view('public.cars.show', [
            'pageTitle' => $car->title,
            'car' => $car,
            'relatedCars' => $relatedCars,
        ]);
    }

    /**
     * Display the events page with real data.
     */
    public function events(): View
    {
        $upcomingEvents = Event::where('status', 'active')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        $featuredEvents = Event::where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

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

        return view('public.events.index', [
            'pageTitle' => 'Event Management',
            'upcomingEvents' => $upcomingEvents,
            'featuredEvents' => $featuredEvents,
            'pastEvents' => $pastEvents,
            'stats' => $stats,
        ]);
    }

    /**
     * Display a single event detail.
     */
    public function eventShow(string $slug): View
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        // Increment view count
        $event->increment('views_count');

        $relatedEvents = Event::where('id', '!=', $event->id)
            ->where('category', $event->category)
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('public.events.show', [
            'pageTitle' => $event->title,
            'event' => $event,
            'relatedEvents' => $relatedEvents,
        ]);
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        $stats = [
            'clients' => House::count() + Car::count() + Event::count(),
            'properties' => House::count(),
            'events' => Event::count(),
            'vehicles' => Car::count(),
        ];

        return view('public.about', [
            'pageTitle' => 'About Us',
            'stats' => $stats,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('public.contact', [
            'pageTitle' => 'Contact Us',
        ]);
    }

    /**
     * Display the gallery page.
     */
    /**
     * Display the gallery page.
     */
    public function gallery(): View
    {
        // Get images from all categories
        $houseImages = House::whereNotNull('cover_image')
            ->where('status', 'available')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($item) {
                return [
                    'src' => $item->cover_image,
                    'alt' => $item->title,
                    'category' => 'housing',
                    'featured' => $item->is_featured ?? false,
                ];
            });

        $eventImages = Event::whereNotNull('cover_image')
            ->where('status', 'active')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($item) {
                return [
                    'src' => $item->cover_image,
                    'alt' => $item->title,
                    'category' => 'events',
                    'featured' => $item->is_featured ?? false,
                ];
            });

        $carImages = Car::whereNotNull('cover_image')
            ->where('status', 'available')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($item) {
                return [
                    'src' => $item->cover_image,
                    'alt' => $item->title,
                    'category' => 'transport',
                    'featured' => $item->is_featured ?? false,
                ];
            });

        // Merge and shuffle all images
        $images = $houseImages->merge($eventImages)->merge($carImages)->shuffle();

        return view('public.gallery', [
            'pageTitle' => 'Our Work',
            'images' => $images,
        ]);
    }

    /**
     * Display the FAQ page.
     */
    public function faq(): View
    {
        // Get real FAQs from database or use defaults
        $faqs = $this->getFaqs();

        return view('public.faq', [
            'pageTitle' => 'Frequently Asked Questions',
            'faqs' => $faqs,
        ]);
    }

    /**
     * Get FAQ data.
     */
    private function getFaqs(): array
    {
        // You can replace this with a Faq model if you have one
        // For now, returning static data
        return [
            [
                'question' => 'What areas do you serve?',
                'answer' => 'We primarily serve Kigali and surrounding areas in Rwanda, with services available nationwide for events and transport.',
            ],
            [
                'question' => 'How do I book a property viewing?',
                'answer' => 'Contact us via WhatsApp or email, and our team will schedule a convenient viewing within 24–48 hours.',
            ],
            [
                'question' => 'Do you offer chauffeur services?',
                'answer' => 'Yes, all our vehicles can be rented with a professional chauffeur upon request.',
            ],
            [
                'question' => 'What is included in event management?',
                'answer' => 'Our event packages include venue coordination, décor, catering liaison, transport, and on-day management.',
            ],
            [
                'question' => 'How can I list my property with ME FOR YOU?',
                'answer' => 'Contact our team with your property details, photos, and pricing. We\'ll handle the listing, viewings, and negotiations.',
            ],
            [
                'question' => 'What types of vehicles are available for rent?',
                'answer' => 'We offer sedans, SUVs, vans, and luxury vehicles. All are well-maintained and available with or without a driver.',
            ],
            [
                'question' => 'Do you offer customized event packages?',
                'answer' => 'Yes, every event is unique. We work with you to create a customized package that fits your vision and budget.',
            ],
            [
                'question' => 'How do I get a quote for your services?',
                'answer' => 'Simply contact us via email, phone, or WhatsApp with your requirements, and we\'ll provide a detailed quote within 24 hours.',
            ],
        ];
    }


    /**
     * Display the team page.
     */
    public function team(): View
    {
        // Featured members (active, featured, ordered, limit 3)
        $featuredMembers = TeamMember::active()
            ->featured()
            ->ordered()
            ->take(3)
            ->get();

        // All other active members (exclude featured)
        $members = TeamMember::active()
            ->ordered()
            ->where('is_featured', false)   // exclude featured
            ->get();

        return view('public.team', [
            'pageTitle' => 'Our Team',
            'members' => $members,
            'featuredMembers' => $featuredMembers,
        ]);
    }

    /**
     * Display a single team member detail.
     */
    public function teamShow(string $slug): View
    {
        $member = TeamMember::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $member->increment('views_count');

        return view('public.team-show', [
            'pageTitle' => $member->name,
            'member' => $member,
        ]);
    }
}