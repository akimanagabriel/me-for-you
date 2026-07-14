<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Event;
use App\Models\House;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalCars = Car::count();
        $totalHouses = House::count();
        $totalEvents = Event::count();
        $totalUsers = User::count();

        // Get status breakdowns
        $carStatuses = Car::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $houseStatuses = House::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $eventStatuses = Event::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get recent activities
        $recentCars = Car::with('owner')->latest()->take(5)->get();
        $recentHouses = House::with('owner')->latest()->take(5)->get();
        $recentEvents = Event::with('owner')->latest()->take(5)->get();

        // Get featured items
        $featuredCars = Car::where('is_featured', true)->latest()->take(3)->get();
        $featuredHouses = House::where('is_featured', true)->latest()->take(3)->get();
        $featuredEvents = Event::where('is_featured', true)->latest()->take(3)->get();

        // Get monthly statistics (last 6 months)
        $monthlyStats = $this->getMonthlyStats();

        // Get top viewed items
        $topViewedCars = Car::orderBy('views_count', 'desc')->take(3)->get();
        $topViewedHouses = House::orderBy('views_count', 'desc')->take(3)->get();
        $topViewedEvents = Event::orderBy('views_count', 'desc')->take(3)->get();

        // Get user with most listings
        $topUser = User::withCount(['cars', 'houses', 'events'])
            ->having('cars_count', '>', 0)
            ->orHaving('houses_count', '>', 0)
            ->orHaving('events_count', '>', 0)
            ->orderByRaw('(cars_count + houses_count + events_count) DESC')
            ->first();

        return view('admin.dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => [
                'total_cars' => $totalCars,
                'total_houses' => $totalHouses,
                'total_events' => $totalEvents,
                'total_users' => $totalUsers,
                'car_statuses' => $carStatuses,
                'house_statuses' => $houseStatuses,
                'event_statuses' => $eventStatuses,
            ],
            'recentCars' => $recentCars,
            'recentHouses' => $recentHouses,
            'recentEvents' => $recentEvents,
            'featuredCars' => $featuredCars,
            'featuredHouses' => $featuredHouses,
            'featuredEvents' => $featuredEvents,
            'monthlyStats' => $monthlyStats,
            'topViewedCars' => $topViewedCars,
            'topViewedHouses' => $topViewedHouses,
            'topViewedEvents' => $topViewedEvents,
            'topUser' => $topUser,
        ]);
    }

    private function getMonthlyStats(): array
    {
        $months = [];
        $carData = [];
        $houseData = [];
        $eventData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M');
            $months[] = $monthName;

            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $carData[] = Car::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $houseData[] = House::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $eventData[] = Event::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        }

        return [
            'months' => $months,
            'cars' => $carData,
            'houses' => $houseData,
            'events' => $eventData,
        ];
    }
}