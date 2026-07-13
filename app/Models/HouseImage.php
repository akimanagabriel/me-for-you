<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseImage extends Model
{
    protected $fillable = [
        'house_id',
        'image_path',
        'alt_text',
        'is_cover',
        'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}