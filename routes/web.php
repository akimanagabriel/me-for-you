<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\ServicePageController;
use Illuminate\Support\Facades\Route;


// Landing Page - Now using controller with database data
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Service Pages
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/events', [ServicePageController::class, 'events'])->name('events');
    Route::get('/events/{slug}', [ServicePageController::class, 'eventShow'])->name('event.show');

    Route::get('/housing', [ServicePageController::class, 'housing'])->name('housing');
    Route::get('/housing/{slug}', [ServicePageController::class, 'houseShow'])->name('house.show');

    Route::get('/transport', [ServicePageController::class, 'transport'])->name('transport');
    Route::get('/transport/{slug}', [ServicePageController::class, 'carShow'])->name('car.show');
});

// Public routes
Route::get('/houses', [PublicPageController::class, 'houses'])->name('houses.index');
Route::get('/houses/{slug}', [PublicPageController::class, 'houseShow'])->name('houses.show');
Route::get('/cars', [PublicPageController::class, 'cars'])->name('cars.index');
Route::get('/cars/{slug}', [PublicPageController::class, 'carShow'])->name('cars.show');
Route::get('/events', [PublicPageController::class, 'events'])->name('events.index');
Route::get('/events/{slug}', [PublicPageController::class, 'eventShow'])->name('events.show');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/gallery', [PublicPageController::class, 'gallery'])->name('gallery');
Route::get('/faq', [PublicPageController::class, 'faq'])->name('faq');

// Public team routes
Route::get('/team', [PublicPageController::class, 'team'])->name('team');
Route::get('/team/{slug}', [PublicPageController::class, 'teamShow'])->name('team.show');


Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::redirect('/home', "/admin")->name('home.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource("houses", HouseController::class)->names("houses");
        Route::put('houses/{house}/toggle-featured', [HouseController::class, 'toggleFeatured'])->name('houses.toggle-featured');

        Route::resource('cars', CarController::class)->names('cars');
        Route::put('cars/{car}/toggle-featured', [CarController::class, 'toggleFeatured'])->name('cars.toggle-featured');

        Route::resource('events', EventController::class)->names('events');
        Route::put('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])->name('events.toggle-featured');

        Route::resource('team-members', TeamMemberController::class)->names('team-members')->except(['show']);
        Route::put('team-members/{teamMember}/toggle', [TeamMemberController::class, 'toggleActive'])->name('team-members.toggle');
        Route::put('team-members/{teamMember}/toggle-featured', [TeamMemberController::class, 'toggleFeatured'])->name('team-members.toggle-featured');


        // Profile routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [ProfileController::class, 'update'])->name('update');

            // Password routes
            Route::get('/password', [ProfileController::class, 'passwordForm'])->name('password');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

            // Email routes
            Route::get('/email', [ProfileController::class, 'emailForm'])->name('email');
            Route::put('/email', [ProfileController::class, 'updateEmail'])->name('email.update');

            // Account deletion
            Route::delete('/delete', [ProfileController::class, 'destroy'])->name('delete');
        });

    });


});
