<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'short_description', 'content', 'banner_image', 'icon', 'visible'];

    protected $casts = ['visible' => 'bool'];

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
