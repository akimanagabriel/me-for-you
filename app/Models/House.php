<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class House extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'type',
        'status',
        'location',
        'city',
        'address',
        'price',
        'currency',
        'price_period',
        'bedrooms',
        'bathrooms',
        'size_sqm',
        'amenities',
        'cover_image',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'size_sqm' => 'integer',
        'views_count' => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(HouseImage::class)->orderBy('sort_order');
    }
}