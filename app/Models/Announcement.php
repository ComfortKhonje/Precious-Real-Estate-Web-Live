<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'content', 'cover_image', 'status', 'published_at', 'is_featured'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'bool',
    ];

    /**
     * Get featured announcements
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get published announcements
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    protected static function booted()
    {
        static::deleted(function ($announcement) {
            if ($announcement->cover_image && str_starts_with($announcement->cover_image, 'precious-real-estate')) {
                app(MediaService::class)->delete($announcement->cover_image);
            }
        });
    }
}
