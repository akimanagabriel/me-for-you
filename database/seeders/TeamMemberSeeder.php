<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        $members = [
            [
                'name' => 'Alice Mutesi',
                'position' => 'CEO & Founder',
                'department' => 'Executive',
                'bio' => 'Alice is the visionary behind ME FOR YOU. With over 10 years of experience in hospitality and service management, she leads the company with passion and dedication.',
                'short_bio' => 'Visionary leader with 10+ years in hospitality.',
                'email' => 'alice@meforyouadvisory.com',
                'phone' => '+250 788 000 001',
                'experience' => '10+ years',
                'education' => 'MBA in Hospitality Management, University of Rwanda',
                'skills' => ['leadership', 'strategic_planning', 'client_relations'],
                'is_featured' => true,
                'order' => 0,
            ],
            [
                'name' => 'David Niyonzima',
                'position' => 'Head of Operations',
                'department' => 'Operations',
                'bio' => 'David ensures that every service runs smoothly. His attention to detail and operational expertise guarantee seamless experiences for every client.',
                'short_bio' => 'Operations expert ensuring seamless service delivery.',
                'email' => 'david@meforyouadvisory.com',
                'phone' => '+250 788 000 002',
                'experience' => '8+ years',
                'education' => 'BSc in Business Administration, University of Kigali',
                'skills' => ['operations', 'logistics', 'team_management'],
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'name' => 'Grace Uwimana',
                'position' => 'Event Director',
                'department' => 'Events',
                'bio' => 'Grace turns visions into reality. With a flair for creativity and meticulous planning, she has orchestrated some of Kigali\'s most memorable events.',
                'short_bio' => 'Creative event planner with a passion for perfection.',
                'email' => 'grace@meforyouadvisory.com',
                'phone' => '+250 788 000 003',
                'experience' => '6+ years',
                'education' => 'BA in Event Management, Kigali Institute of Tourism',
                'skills' => ['event_planning', 'decor', 'vendor_management'],
                'order' => 2,
            ],
            [
                'name' => 'Jean-Pierre Habimana',
                'position' => 'Housing Manager',
                'department' => 'Housing',
                'bio' => 'Jean-Pierre is the go-to expert for property and housing solutions. He guides clients through every step of finding their perfect home.',
                'short_bio' => 'Property expert helping clients find their dream homes.',
                'email' => 'jp@meforyouadvisory.com',
                'phone' => '+250 788 000 004',
                'experience' => '7+ years',
                'education' => 'BSc in Real Estate Management, University of Rwanda',
                'skills' => ['property_management', 'client_relations', 'negotiation'],
                'order' => 3,
            ],
            [
                'name' => 'Chantal Mukamana',
                'position' => 'Transport Coordinator',
                'department' => 'Transport',
                'bio' => 'Chantal manages the fleet with precision and care. She ensures that every vehicle is ready and every journey is comfortable and safe.',
                'short_bio' => 'Fleet manager ensuring safe and comfortable journeys.',
                'email' => 'chantal@meforyouadvisory.com',
                'phone' => '+250 788 000 005',
                'experience' => '5+ years',
                'education' => 'Diploma in Logistics, Kigali Technical College',
                'skills' => ['fleet_management', 'logistics', 'customer_service'],
                'order' => 4,
            ],
            [
                'name' => 'Olivier Nsengimana',
                'position' => 'Marketing & Communications',
                'department' => 'Marketing',
                'bio' => 'Olivier brings the ME FOR YOU story to life. Through creative campaigns and authentic engagement, he connects the brand with its community.',
                'short_bio' => 'Creative marketer building the ME FOR YOU brand.',
                'email' => 'olivier@meforyouadvisory.com',
                'phone' => '+250 788 000 006',
                'experience' => '4+ years',
                'education' => 'BA in Marketing, University of Kigali',
                'skills' => ['marketing', 'content_creation', 'social_media'],
                'order' => 5,
            ],
        ];

        foreach ($members as $index => $memberData) {
            $memberData['slug'] = Str::slug($memberData['name']) . '-' . Str::random(4);
            $memberData['user_id'] = !empty($userIds) ? fake()->randomElement($userIds) : null;
            $memberData['image'] = "https://picsum.photos/seed/team-{$index}/400/400";

            TeamMember::create($memberData);
        }
    }
}