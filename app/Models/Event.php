<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'category',
        'status',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'location',
        'city',
        'address',
        'price',
        'currency',
        'price_period',
        'features',
        'requirements',
        'speaker',
        'host',
        'organizer',
        'contact_email',
        'contact_phone',
        'cover_image',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'features' => 'array',
        'requirements' => 'array',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * The user who created/owns this event.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * All gallery images for this event, ordered for display.
     */
    public function images(): HasMany
    {
        return $this->hasMany(EventImage::class)->orderBy('sort_order');
    }

    /**
     * Get the single image flagged as the cover/primary image.
     */
    public function coverImage(): HasOne
    {
        return $this->hasOne(EventImage::class)->where('is_cover', true);
    }

    /**
     * Scope a query to only include active events.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->where('status', 'active');
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString())
            ->orWhere('status', 'completed');
    }

    /**
     * Check if event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->event_date >= now()->toDateString() && $this->status === 'active';
    }

    /**
     * Check if event is past.
     */
    public function isPast(): bool
    {
        return $this->event_date < now()->toDateString() || $this->status === 'completed';
    }
}