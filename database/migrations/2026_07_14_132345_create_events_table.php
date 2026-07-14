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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Ownership / authorship
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Core identity
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Event details
            $table->string('category')->default('conference'); // conference, wedding, corporate, private, concert, exhibition, party, workshop, seminar
            $table->string('status')->default('draft'); // draft, active, completed, cancelled, postponed

            // Date & Time
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Location
            $table->string('venue')->nullable();
            $table->string('location');
            $table->string('city')->default('Kigali');
            $table->string('address')->nullable();

            // Pricing
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 3)->default('RWF');
            $table->string('price_period')->default('total'); // total, per_person, per_hour


            // Features & Requirements
            $table->json('features')->nullable(); // e.g. ["catering", "audio_visual", "parking", "security"]
            $table->json('requirements')->nullable(); // e.g. ["dress_code", "age_restriction", "registration_required"]

            // Speaker / Host
            $table->string('speaker')->nullable();
            $table->string('host')->nullable();
            $table->string('organizer')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            // Presentation
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);


            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['status', 'category']);
            $table->index(['event_date', 'status']);
            $table->index(['location', 'city']);
            $table->index(['category', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};