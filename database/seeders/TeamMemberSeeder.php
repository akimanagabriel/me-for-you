<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records (optional – comment out to keep existing)
        // TeamMember::truncate();

        $members = [
            [
                'name' => 'Papy Patrick Ndazigaruye',
                'position' => 'CEO & Founder',
                'department' => 'Executive',
                'bio' => 'Papy Patrick is the visionary founder of ME FOR YOU. With over 15 years of experience in business management and client relations, he leads the company with a commitment to excellence and integrity.',
                'short_bio' => 'Visionary leader with 15+ years of experience.',
                'experience' => '15+ years',
                'education' => 'MBA in Strategic Management, University of Rwanda',
                'skills' => ['leadership', 'strategic_planning', 'client_relations'],
                'is_featured' => true,
                'order' => 0,
            ],
            [
                'name' => 'Stephano Niyonsenga',
                'position' => 'Programs Manager',
                'department' => 'Programs',
                'bio' => 'Stephano oversees all programs and ensures they are delivered on time and within scope. He brings a wealth of experience in project management and team coordination.',
                'short_bio' => 'Programs expert ensuring smooth project delivery.',
                'experience' => '10+ years',
                'education' => 'BSc in Project Management, University of Kigali',
                'skills' => ['operations', 'team_management', 'client_relations'],
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'name' => 'Jane Uwiringiyimana',
                'position' => 'Customer Engagement Manager',
                'department' => 'Customer Service',
                'bio' => 'Jane leads the customer engagement team, ensuring every client receives personalized attention and a seamless experience from first contact to final delivery.',
                'short_bio' => 'Customer service expert dedicated to client satisfaction.',
                'experience' => '8+ years',
                'education' => 'BA in Communication, Kigali Institute of Technology',
                'skills' => ['customer_service', 'communication', 'client_relations'],
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'name' => 'Faustin Habineza',
                'position' => 'Event Coordinator',
                'department' => 'Events',
                'bio' => 'Faustin brings creativity and precision to every event. With a background in event planning, he ensures every detail is executed flawlessly.',
                'short_bio' => 'Creative event planner with an eye for detail.',
                'experience' => '6+ years',
                'education' => 'Diploma in Event Management, Kigali Tourism College',
                'skills' => ['event_planning', 'decor', 'vendor_management'],
                'is_featured' => false,
                'order' => 3,
            ],
            [
                'name' => 'Yvette Kumi',
                'position' => 'Accountant',
                'department' => 'Finance',
                'bio' => 'Yvette manages the company’s finances with precision and transparency. She ensures accurate records and timely reporting, supporting the company’s financial health.',
                'short_bio' => 'Financial expert ensuring transparency and accuracy.',
                'experience' => '5+ years',
                'education' => 'BSc in Accounting, University of Rwanda',
                'skills' => ['financial_management', 'accounting', 'reporting'],
                'is_featured' => false,
                'order' => 4,
            ],
            [
                'name' => 'Claudine Igiraneza',
                'position' => 'Logistics & Operations Officer',
                'department' => 'Operations',
                'bio' => 'Claudine ensures that all logistics and operations run smoothly. From fleet management to supply chain, she keeps the wheels turning.',
                'short_bio' => 'Operations expert keeping everything moving.',
                'experience' => '7+ years',
                'education' => 'BSc in Logistics, Kigali Technical University',
                'skills' => ['logistics', 'fleet_management', 'operations'],
                'is_featured' => false,
                'order' => 5,
            ],
            [
                'name' => 'Keren Gisubizo',
                'position' => 'Event Coordinator',
                'department' => 'Events',
                'bio' => 'Keren is passionate about creating memorable experiences. She coordinates events with creativity and attention to detail, ensuring each one is unique.',
                'short_bio' => 'Passionate event coordinator with a creative touch.',
                'experience' => '4+ years',
                'education' => 'BA in Hospitality Management, University of Kigali',
                'skills' => ['event_planning', 'decor', 'customer_service'],
                'is_featured' => false,
                'order' => 6,
            ],
            [
                'name' => 'Bosco Nshizirungu',
                'position' => 'Event Coordinator',
                'department' => 'Events',
                'bio' => 'Bosco brings a proactive approach to event coordination. He works closely with clients to bring their vision to life, handling every detail with care.',
                'short_bio' => 'Detail-oriented coordinator who brings visions to life.',
                'experience' => '5+ years',
                'education' => 'Diploma in Event Management, Kigali Tourism College',
                'skills' => ['event_planning', 'vendor_management', 'communication'],
                'is_featured' => false,
                'order' => 7,
            ],
            [
                'name' => 'Fred Izabayo Shumbusho',
                'position' => 'Transport Coordinator',
                'department' => 'Transport',
                'bio' => 'Fred manages the transport fleet with professionalism. He ensures vehicles are well-maintained and schedules are met, providing reliable service to clients.',
                'short_bio' => 'Fleet manager ensuring safe and timely transport.',
                'experience' => '6+ years',
                'education' => 'BSc in Logistics, University of Rwanda',
                'skills' => ['fleet_management', 'logistics', 'customer_service'],
                'is_featured' => false,
                'order' => 8,
            ],
            [
                'name' => 'Tumusifu Shyaka',
                'position' => 'Housing Coordinator',
                'department' => 'Housing',
                'bio' => 'Tumusifu helps clients find their dream homes. With a deep understanding of the local property market, he guides clients through every step of the process.',
                'short_bio' => 'Housing expert helping clients find their perfect home.',
                'experience' => '5+ years',
                'education' => 'BSc in Real Estate, University of Kigali',
                'skills' => ['property_management', 'client_relations', 'negotiation'],
                'is_featured' => false,
                'order' => 9,
            ],
        ];

        // clear table before seeding 
        DB::table('team_members')->truncate();

        foreach ($members as $index => $memberData) {
            // Generate a unique slug from the name
            $slug = Str::slug($memberData['name']) . '-' . Str::random(4);

            // Build avatar URL using ui-avatars.com
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($memberData['name']) . '&size=400&background=random&color=fff&font-size=0.5&bold=true';

            // Set default values
            $memberData['slug'] = $slug;
            $memberData['user_id'] = null;
            $memberData['phone'] = '+250 788 ' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) . ' ' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            $memberData['email'] = strtolower(Str::slug($memberData['name'])) . '@meforyouadvisory.com';
            $memberData['image'] = $avatarUrl;
            $memberData['is_active'] = true;
            $memberData['views_count'] = 0;

            TeamMember::create($memberData);
        }
    }
}