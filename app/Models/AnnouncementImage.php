<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'image_path',
        'sort_order',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
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
