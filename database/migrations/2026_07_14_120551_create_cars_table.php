<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            // Ownership / authorship
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Core identity
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Vehicle identity
            $table->string('make');
            $table->string('model');
            $table->unsignedSmallInteger('year');
            $table->string('vin', 32)->nullable()->unique();
            $table->string('color')->nullable();

            // Classification
            $table->string('body_type')->default('sedan'); // sedan, suv, hatchback, coupe, pickup, van, convertible
            $table->string('status')->default('available'); // available, reserved, sold, unavailable
            $table->string('condition')->default('used'); // new, used, certified_pre_owned
            $table->string('fuel_type')->default('petrol'); // petrol, diesel, hybrid, electric
            $table->string('transmission')->default('automatic'); // automatic, manual

            // Pricing
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('RWF');
            $table->string('price_period')->default('total'); // total (for sale), day, month (for rental)

            // Specs
            $table->unsignedInteger('mileage')->default(0); // in km
            $table->decimal('engine_capacity', 4, 1)->nullable(); // in liters
            $table->unsignedTinyInteger('seats')->default(5);
            $table->unsignedTinyInteger('doors')->default(4);
            $table->json('features')->nullable(); // e.g. ["ac", "bluetooth", "sunroof", "backup_camera"]

            // Presentation
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'body_type']);
            $table->index(['make', 'model']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};