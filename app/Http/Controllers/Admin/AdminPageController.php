<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    private array $pages = [
        'houses' => ['title' => 'Houses', 'icon' => 'housing', 'description' => 'Manage property listings, viewings, and rental agreements.'],
        'cars' => ['title' => 'Cars', 'icon' => 'transport', 'description' => 'Manage vehicle fleet, rentals, and chauffeur assignments.'],
        'events' => ['title' => 'Events', 'icon' => 'events', 'description' => 'Manage event packages, bookings, and coordination.'],
        'categories' => ['title' => 'Categories', 'icon' => 'categories', 'description' => 'Organize listings into categories and subcategories.'],
        'locations' => ['title' => 'Locations', 'icon' => 'locations', 'description' => 'Manage service areas and location data.'],
        'bookings' => ['title' => 'Bookings', 'icon' => 'bookings', 'description' => 'View and manage all customer bookings.'],
        'inquiries' => ['title' => 'Inquiries', 'icon' => 'inquiries', 'description' => 'Respond to customer inquiries and leads.'],
        'reviews' => ['title' => 'Reviews', 'icon' => 'reviews', 'description' => 'Moderate and respond to customer reviews.'],
        'users' => ['title' => 'Users', 'icon' => 'users', 'description' => 'Manage registered users and accounts.'],
        'roles' => ['title' => 'Roles & Permissions', 'icon' => 'roles', 'description' => 'Configure Spatie roles and permissions.'],
        'settings' => ['title' => 'Website Settings', 'icon' => 'settings', 'description' => 'Configure site-wide settings and branding.'],
        'banners' => ['title' => 'Banners', 'icon' => 'banners', 'description' => 'Manage homepage and promotional banners.'],
        'faqs' => ['title' => 'FAQs', 'icon' => 'faqs', 'description' => 'Manage frequently asked questions.'],
        'subscribers' => ['title' => 'Newsletter Subscribers', 'icon' => 'subscribers', 'description' => 'Manage newsletter subscriber list.'],
        'activity-logs' => ['title' => 'Activity Logs', 'icon' => 'logs', 'description' => 'View system activity and audit logs.'],
        'profile' => ['title' => 'Profile', 'icon' => 'profile', 'description' => 'Manage your account profile and preferences.'],
    ];

    public function index(string $resource): View
    {
        abort_unless(isset($this->pages[$resource]), 404);

        $page = $this->pages[$resource];

        return view('admin.resource.index', [
            'pageTitle' => $page['title'],
            'resource' => $resource,
            'description' => $page['description'],
            'breadcrumbs' => [['label' => $page['title']]],
            'items' => $this->sampleItems($resource),
        ]);
    }

    private function sampleItems(string $resource): array
    {
        return match ($resource) {
            'houses' => [
                ['id' => 1, 'name' => 'Kigali Heights Apartment', 'status' => 'available', 'location' => 'Kacyiru', 'price' => 'RWF 450,000/mo'],
                ['id' => 2, 'name' => 'Nyarutarama Villa', 'status' => 'available', 'location' => 'Nyarutarama', 'price' => 'RWF 1,200,000/mo'],
                ['id' => 3, 'name' => 'Remera Townhouse', 'status' => 'rented', 'location' => 'Remera', 'price' => 'RWF 650,000/mo'],
            ],
            'cars' => [
                ['id' => 1, 'name' => 'Toyota RAV4', 'status' => 'available', 'type' => 'SUV', 'price' => 'RWF 80,000/day'],
                ['id' => 2, 'name' => 'Mercedes E-Class', 'status' => 'available', 'type' => 'Sedan', 'price' => 'RWF 120,000/day'],
                ['id' => 3, 'name' => 'Toyota Hiace', 'status' => 'booked', 'type' => 'Van', 'price' => 'RWF 150,000/day'],
            ],
            'events' => [
                ['id' => 1, 'name' => 'Wedding Planning', 'status' => 'active', 'category' => 'Weddings', 'price' => 'From RWF 2M'],
                ['id' => 2, 'name' => 'Corporate Conference', 'status' => 'active', 'category' => 'Corporate', 'price' => 'From RWF 1.5M'],
            ],
            'inquiries' => [
                ['id' => 1, 'name' => 'John Doe', 'status' => 'pending', 'subject' => 'Apartment inquiry', 'date' => '2025-07-08'],
                ['id' => 2, 'name' => 'Jane Smith', 'status' => 'replied', 'subject' => 'Wedding planning', 'date' => '2025-07-07'],
            ],
            'bookings' => [
                ['id' => 1, 'name' => 'David N.', 'status' => 'confirmed', 'service' => 'Transport', 'date' => '2025-07-15'],
                ['id' => 2, 'name' => 'Amina K.', 'status' => 'pending', 'service' => 'Housing', 'date' => '2025-07-20'],
            ],
            'users' => [
                ['id' => 1, 'name' => 'Admin User', 'status' => 'active', 'role' => 'Administrator', 'email' => 'admin@me-for-you.org'],
                ['id' => 2, 'name' => 'Staff Member', 'status' => 'active', 'role' => 'Staff', 'email' => 'staff@me-for-you.org'],
            ],
            default => [
                ['id' => 1, 'name' => 'Sample Item 1', 'status' => 'active'],
                ['id' => 2, 'name' => 'Sample Item 2', 'status' => 'inactive'],
            ],
        };
    }
}
