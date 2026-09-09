<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'tagline', 'short_description', 'content', 'features', 'banner_image', 'icon', 'service_icon_id', 'visible'];

    protected $casts = ['visible' => 'bool', 'features' => 'array'];

    public function serviceIcon()
    {
        return $this->belongsTo(ServiceIcon::class);
    }

    /**
     * URL of the banner image at a given MediaService size ('thumbnail',
     * 'medium', 'large'). Returns null (rather than a placeholder) when
     * unset — the CMS card grid falls back to the assigned service icon
     * instead of a generic image placeholder.
     *
     * banner_image holds two different shapes depending on when the row
     * was created: seed data points straight at a public asset file (e.g.
     * "brand-assets/3 Services Page/Image 1.png"), while anything uploaded
     * through the CMS goes through MediaService and is a
     * "precious-real-estate/..." directory holding large/medium/thumbnail
     * variants — the same distinction booted() below already relies on to
     * decide whether a deleted service's file is safe to clean up.
     */
    public function bannerImageUrl(string $size = 'medium'): ?string
    {
        if (! $this->banner_image) {
            return null;
        }

        if (str_starts_with($this->banner_image, 'http')) {
            return $this->banner_image;
        }

        if (! str_starts_with($this->banner_image, 'precious-real-estate/')) {
            return asset($this->banner_image);
        }

        return asset("storage/{$this->banner_image}/{$size}.webp");
    }

    /**
     * Get visible services
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    protected static function booted()
    {
        static::deleted(function ($service) {
            if ($service->banner_image && str_starts_with($service->banner_image, 'precious-real-estate')) {
                app(MediaService::class)->delete($service->banner_image);
            }
        });
    }
}
