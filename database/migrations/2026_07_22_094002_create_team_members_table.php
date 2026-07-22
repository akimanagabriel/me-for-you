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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();

            // Ownership / authorship
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Core identity
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('position')->nullable();
            $table->string('department')->nullable();

            // Biography
            $table->text('bio')->nullable();
            $table->text('short_bio')->nullable();

            // Contact information
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Professional details
            $table->string('experience')->nullable(); // e.g., "5+ years"
            $table->text('education')->nullable();
            $table->json('skills')->nullable(); // e.g., ["event_planning", "property_management"]

            // Presentation - Single image (profile photo)
            $table->string('image')->nullable();

            // Visibility & sorting
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            // Stats
            $table->unsignedInteger('views_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['position', 'department']);
            $table->index(['is_active', 'is_featured']);
            $table->index(['order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};