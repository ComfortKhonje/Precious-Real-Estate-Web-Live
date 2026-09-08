<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'qualifications',
        'years_experience',
        'bio',
        'photo_url',
        'order',
        'visible',
    ];

    protected $casts = [
        'visible' => 'bool',
        'years_experience' => 'integer',
    ];

    /**
     * URL of the profile photo at a given MediaService size ('thumbnail',
     * 'medium', 'large'). Falls back to the same placeholder used by
     * Property/Announcement when no photo has been uploaded yet — the
     * public team page used to build `storage/{photo_url}/{size}.webp`
     * directly with no fallback, so an empty photo_url (the default for a
     * newly created member) rendered a broken image instead of a
     * placeholder. Fixed 2026-09-08.
     */
    public function photoUrl(string $size = 'medium'): string
    {
        if (! $this->photo_url) {
            return asset('brand-assets/no-image-placeholder.svg');
        }

        if (str_starts_with($this->photo_url, 'http')) {
            return $this->photo_url;
        }

        return asset("storage/{$this->photo_url}/{$size}.webp");
    }

    /**
     * Get visible team members
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Order team members
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('name', 'asc');
    }

    protected static function booted()
    {
        static::deleted(function ($member) {
            if ($member->photo_url && str_starts_with($member->photo_url, 'precious-real-estate')) {
                app(MediaService::class)->delete($member->photo_url);
            }
        });
    }
}
