<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => [
                'houses' => 500,
                'cars' => 24,
                'events' => 100,
                'bookings' => 38,
                'inquiries' => 12,
                'users' => 156,
            ],
        ]);
    }
}
