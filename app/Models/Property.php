<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    /**
     * Canonical listing-status vocabulary. Confirmed 2026-09-02 as the
     * correct one — matches the migration's own inline comment, matches
     * the public frontend's comparisons, matches the CMS list filter.
     * (Two other vocabularies — 'available'/'active' and 'Available'/
     * 'Sold'/'Rented' — existed elsewhere in the codebase and were wrong;
     * removed during the 2026-09 property-form rebuild.)
     */
    public const STATUSES = ['For Sale', 'For Rent'];

    /**
     * Fixed property-type list. Was free text before 2026-09-02 (typo-prone
     * against the public filter, which matches on this column) — converted
     * to a fixed dropdown per Comfort's decision.
     */
    public const TYPES = ['House', 'Apartment', 'Plot', 'Commercial', 'Land', 'Office'];

    public const CATEGORIES = ['Residential', 'Commercial'];

    public const CURRENCIES = ['MWK', 'USD'];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'type',
        'price',
        'currency',
        'location',
        'status',
        'bedrooms',
        'bathrooms',
        'land_size',
        'parking_spaces',
        'features',
        'nearby_amenities',
        'featured_image',
        'is_featured',
        'is_available',
    ];

    protected $casts = [
        'is_featured' => 'bool',
        'is_available' => 'bool',
        'features' => 'array',
        'nearby_amenities' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Included automatically whenever a Property is JSON-serialized (API
     * responses, or json_encode()'d straight into an Alpine x-data block
     * as the public properties page does) — so frontend JS never has to
     * re-derive price/image logic that already lives here.
     */
    protected $appends = ['formatted_price', 'featured_image_url', 'thumbnail_image_url'];

    protected static function booted(): void
    {
        // Slug is server-generated, always — never trust client input for it.
        // Only set on creation; editing a property never silently changes its
        // slug, so existing shared links keep working.
        static::creating(function (Property $property) {
            if (! $property->slug) {
                $property->slug = static::uniqueSlugFrom($property->title);
            }
        });

        static::deleted(function (Property $property) {
            // Each PropertyImage's own delete-observer cleans up its files;
            // this just makes sure the child rows go too.
            $property->images()->get()->each->delete();
        });
    }

    protected static function uniqueSlugFrom(string $title): string
    {
        $base = Str::slug($title) ?: 'property';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /**
     * Get all inquiries related to this property
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Get all images related to this property, gallery order first.
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    /**
     * Get the featured cover image record.
     */
    public function coverImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_featured', true)->latestOfMany();
    }

    /**
     * URL of the featured image at a given MediaService size
     * ('thumbnail', 'medium', 'large'). Falls back to a static placeholder
     * if this property has no featured image yet.
     */
    public function featuredImageUrl(string $size = 'medium'): string
    {
        if (! $this->featured_image) {
            return asset('brand-assets/no-image-placeholder.svg');
        }

        return asset("storage/{$this->featured_image}/{$size}.webp");
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->featuredImageUrl('medium');
    }

    public function getThumbnailImageUrlAttribute(): string
    {
        return $this->featuredImageUrl('thumbnail');
    }

    /**
     * Price formatted for display, currency-prefixed, with the correct
     * "/ month" suffix for rentals. Single source of truth — every view
     * that shows a price should call this, not re-derive the suffix logic
     * itself (that duplication is exactly how the For Sale/For Rent suffix
     * bug happened — fixed in two places, inverted in a third, 2026-09-02).
     */
    public function getFormattedPriceAttribute(): string
    {
        $amount = number_format((float) $this->price, 0);
        $formatted = trim("{$this->currency} {$amount}");

        return $this->status === 'For Rent' ? "{$formatted} / month" : $formatted;
    }

    /**
     * Get featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get available (still-listed) properties. Replaces the old scope of
     * the same name, which checked for status values ('available'/'active')
     * that never actually existed in this column — dead/broken code, never
     * matched anything, removed 2026-09-02.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
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
