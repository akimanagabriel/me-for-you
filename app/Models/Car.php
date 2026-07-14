<?php

namespace App\Models;

use App\Models\CarImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'make',
        'model',
        'year',
        'vin',
        'color',
        'body_type',
        'status',
        'condition',
        'fuel_type',
        'transmission',
        'price',
        'currency',
        'price_period',
        'mileage',
        'engine_capacity',
        'seats',
        'doors',
        'features',
        'cover_image',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'year' => 'integer',
        'price' => 'decimal:2',
        'mileage' => 'integer',
        'engine_capacity' => 'decimal:1',
        'seats' => 'integer',
        'doors' => 'integer',
        'features' => 'array',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * The user who owns/listed this car.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * All gallery images for this car, ordered for display.
     */
    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    /**
     * The single image flagged as the cover/primary gallery image.
     */
    public function coverImage(): HasOne
    {
        return $this->hasOne(CarImage::class)->where('is_cover', true);
    }
}