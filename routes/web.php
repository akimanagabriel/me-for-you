<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page', ['transparentNav' => true]);
})->name('home');

Route::get('/houses', [PublicPageController::class, 'houses'])->name('houses.index');
Route::get('/houses/{slug}', [PublicPageController::class, 'houseShow'])->name('houses.show');
Route::get('/cars', [PublicPageController::class, 'cars'])->name('cars.index');
Route::get('/cars/{slug}', [PublicPageController::class, 'carShow'])->name('cars.show');
Route::get('/events', [PublicPageController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [PublicPageController::class, 'eventShow'])->name('events.show');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
Route::get('/gallery', [PublicPageController::class, 'gallery'])->name('gallery');
Route::get('/faq', [PublicPageController::class, 'faq'])->name('faq');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::redirect('/home', "/admin")->name('home.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource("houses", HouseController::class)->names("houses");
        Route::resource('cars', CarController::class)->names('cars');

        $resources = [
            'events',
            'categories',
            'locations',
            'bookings',
            'inquiries',
            'reviews',
            'users',
            'roles',
            'settings',
            'banners',
            'faqs',
            'subscribers',
            'activity-logs',
            'profile',
        ];

        foreach ($resources as $resource) {
            Route::get("/{$resource}", [AdminPageController::class, 'index'])
                ->defaults('resource', $resource)
                ->name("{$resource}.index");
        }
    });


});
