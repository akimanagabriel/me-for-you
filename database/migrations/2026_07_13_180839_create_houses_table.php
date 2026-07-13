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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();

            // Ownership / authorship
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Core identity
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Classification
            $table->string('type')->default('apartment'); // apartment, villa, townhouse, studio, etc.
            $table->string('status')->default('available'); // available, rented, unavailable

            // Location
            $table->string('location');
            $table->string('city')->default('Kigali');
            $table->string('address')->nullable();

            // Pricing
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('RWF');
            $table->string('price_period')->default('month'); // month, day, night

            // Specs
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedInteger('size_sqm')->nullable();
            $table->json('amenities')->nullable(); // e.g. ["wifi", "parking", "pool"]

            // Presentation
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
