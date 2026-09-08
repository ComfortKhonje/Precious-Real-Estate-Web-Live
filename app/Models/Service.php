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
