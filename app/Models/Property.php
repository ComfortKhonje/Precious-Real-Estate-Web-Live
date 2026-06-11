<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'category', 'type', 'price', 'location', 'status',
        'bedrooms', 'bathrooms', 'land_size', 'parking', 'features', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'bool',
        'features' => 'array',
    ];

    /**
     * Get all inquiries related to this property
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Get all images related to this property
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    /**
     * Get the featured cover image
     */
    public function coverImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_featured', true)->latestOfMany();
    }

    /**
     * Get featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get available properties (for sale/rent)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->orWhere('status', 'active');
    }

    /**
     * Search properties by title or location
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
            ->orWhere('location', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Filter by price range
     */
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Filter by type (residential, commercial, etc)
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Filter by bedrooms
     */
    public function scopeByBedrooms($query, $bedrooms)
    {
        return $query->where('bedrooms', '>=', $bedrooms);
    }
}
