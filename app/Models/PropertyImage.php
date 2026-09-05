<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'image_type',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * URL of this image at a given MediaService size
     * ('thumbnail', 'medium', 'large').
     */
    public function url(string $size = 'medium'): string
    {
        return asset("storage/{$this->image_path}/{$size}.webp");
    }

    protected static function booted()
    {
        static::deleted(function ($image) {
            if ($image->image_path) {
                app(MediaService::class)->delete($image->image_path);
            }
        });
    }
}
