<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['conference', 'wedding', 'corporate', 'private', 'concert', 'exhibition', 'party', 'workshop', 'seminar'];
        $statuses = ['draft', 'active', 'active', 'active', 'completed', 'cancelled', 'postponed'];
        $pricePeriods = ['total', 'total', 'per_person', 'per_hour'];
        $cities = ['Kigali', 'Kigali', 'Kigali', 'Musanze', 'Rubavu', 'Nyamata', 'Muhanga', 'Rwamagana'];
        $venues = [
            'Kigali Convention Centre',
            'Radisson Blu Hotel',
            'Marriott Hotel',
            'Serena Hotel',
            'Ubumwe Grande Hotel',
            'Park Inn by Radisson',
            'Kigali Golf Club',
            'Village Urugwiro',
            'Kigali Arena',
            'Norrsken House',
            'The Retreat',
            'Heaven Restaurant',
        ];
        $locations = ['Kacyiru', 'Kimihurura', 'Nyarutarama', 'Remera', 'Gikondo', 'Nyamirambo', 'Kimironko'];

        $featurePool = [
            'catering',
            'audio_visual',
            'parking',
            'security',
            'wifi',
            'photography',
            'videography',
            'decorations',
            'live_music',
            'dj',
            'bar_service',
            'tents',
            'lighting',
            'stage'
        ];

        $requirementPool = [
            'dress_code',
            'age_restriction',
            'registration_required',
            'id_required',
            'invitation_only',
            'vaccination_required'
        ];

        $userIds = User::pluck('id');

        $eventTitles = [
            'Kigali Tech Summit',
            'Rwanda Startup Conference',
            'Digital Innovation Forum',
            'Annual Gala Dinner',
            'Corporate Awards Night',
            'Networking Mixer',
            'Executive Leadership Retreat',
            'Business Breakfast Meeting',
            'Kigali Food Festival',
            'Art Exhibition',
            'Music Concert',
            'Wedding Celebration',
            'Anniversary Party',
            'Birthday Bash',
            'Product Launch Event',
            'Brand Showcase',
            'Press Conference',
            'Leadership Workshop',
            'Innovation Hackathon',
            'Coding Bootcamp',
            'Sustainability Seminar',
            'Health & Wellness Conference',
            'Fashion Show',
            'Cultural Festival',
            'Community Gathering',
        ];

        for ($i = 0; $i < 25; $i++) {
            $title = fake()->randomElement($eventTitles) . ' ' . fake()->year();
            $slug = Str::slug($title) . '-' . Str::lower(Str::random(4));

            $eventDate = fake()->dateTimeBetween('-6 months', '+6 months');
            $startTime = fake()->time('H:i', '09:00:00');
            $endTime = fake()->time('H:i', '18:00:00');

            // Ensure end time is after start time
            while ($endTime <= $startTime) {
                $endTime = fake()->time('H:i', '23:00:00');
            }

            $hasPrice = fake()->boolean(70); // 70% of events have a price
            $price = $hasPrice ? fake()->numberBetween(50_000, 5_000_000) : null;

            $event = Event::create([
                'user_id' => $userIds->isNotEmpty() ? fake()->randomElement($userIds->all()) : null,
                'title' => $title,
                'slug' => $slug,
                'description' => fake()->paragraphs(4, true),
                'category' => fake()->randomElement($categories),
                'status' => fake()->randomElement($statuses),
                'event_date' => $eventDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'venue' => fake()->randomElement($venues),
                'location' => fake()->randomElement($locations),
                'city' => fake()->randomElement($cities),
                'address' => fake()->optional()->streetAddress(),
                'price' => $price,
                'currency' => 'RWF',
                'price_period' => fake()->randomElement($pricePeriods),
                'features' => fake()->randomElements($featurePool, fake()->numberBetween(2, 6)),
                'requirements' => fake()->randomElements($requirementPool, fake()->numberBetween(0, 3)),
                'speaker' => fake()->optional()->name(),
                'host' => fake()->optional()->name(),
                'organizer' => fake()->optional()->company(),
                'contact_email' => fake()->optional()->email(),
                'contact_phone' => fake()->optional()->phoneNumber(),
                'cover_image' => "https://picsum.photos/seed/event-{$slug}-cover/1200/800",
                'is_featured' => fake()->boolean(20),
                'views_count' => fake()->numberBetween(0, 8000),
            ]);

            $imageCount = fake()->numberBetween(3, 7);

            $images = [];
            for ($j = 0; $j < $imageCount; $j++) {
                $images[] = [
                    'image_path' => "https://picsum.photos/seed/event-{$slug}-{$j}/1200/800",
                    'alt_text' => $title,
                    'is_cover' => $j === 0,
                    'sort_order' => $j,
                ];
            }

            $event->images()->createMany($images);
        }
    }
}