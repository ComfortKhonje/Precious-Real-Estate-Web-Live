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
        'bio',
        'photo_url',
        'order',
        'visible',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

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
