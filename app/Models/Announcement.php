<?php

namespace App\Models;

use App\Services\MediaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * Real category vocabulary, replacing the fake per-item badges the old
     * hardcoded Updates page used to show. Added 2026-09-04.
     */
    public const CATEGORIES = ['Announcement', 'Market Update', 'Notice'];

    protected $fillable = ['title', 'category', 'summary', 'content', 'cover_image', 'status', 'published_at', 'is_featured'];

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

    /**
     * Extra gallery images beyond the single cover_image.
     */
    public function images()
    {
        return $this->hasMany(AnnouncementImage::class)->orderBy('sort_order');
    }

    /**
     * URL of the cover image at a given MediaService size
     * ('thumbnail', 'medium', 'large'). Handles the legacy case where
     * cover_image was stored as a full URL rather than a MediaService
     * directory path.
     */
    public function coverImageUrl(string $size = 'medium'): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }

        return asset("storage/{$this->cover_image}/{$size}.webp");
    }

    /**
     * Very deliberately NOT a full HTML sanitizer — no HTMLPurifier-class
     * package is installed in this project. This is a pragmatic allowlist
     * strip for a low-traffic internal CMS where only trusted staff (not
     * public users) write this content. If announcements content is ever
     * opened to untrusted authors, replace this with a real sanitizer
     * (e.g. mews/purifier) before that happens — flagged in the
     * maintenance plan doc, not fixed further here.
     */
    public static function sanitizeContent(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        // strip_tags() only filters TAGS — it keeps every attribute on the
        // tags it allows. That left `onerror=`, `onclick=` and
        // `href="javascript:..."` intact on allowed <a> and <img> elements,
        // and news/show.blade.php renders this with {!! !!}. A CMS account
        // (or anyone who took one over) could therefore store XSS that fires
        // for every public visitor. The two passes below close that off.
        $html = strip_tags(
            $html,
            '<p><br><strong><b><em><i><u><s><ol><ul><li><a><h2><h3><h4><blockquote><img>'
        );

        // Drop every inline event handler (on*="..." / on*='...' / on*=bare).
        $html = preg_replace('/\son[a-z-]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        // Drop javascript:/vbscript:/data: URLs, but keep inline data:image
        // (Quill can legitimately produce those for pasted images).
        $html = preg_replace_callback(
            '/\s(href|src)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i',
            function (array $match) {
                $value = trim($match[2], "\"'");
                $normalized = strtolower(preg_replace('/\s+/', '', $value));

                $blocked = str_starts_with($normalized, 'javascript:')
                    || str_starts_with($normalized, 'vbscript:')
                    || (str_starts_with($normalized, 'data:') && ! str_starts_with($normalized, 'data:image/'));

                return $blocked ? '' : $match[0];
            },
            $html
        );

        return $html;
    }

    protected static function booted()
    {
        static::deleted(function ($announcement) {
            if ($announcement->cover_image && str_starts_with($announcement->cover_image, 'precious-real-estate')) {
                app(MediaService::class)->delete($announcement->cover_image);
            }

            $announcement->images()->get()->each->delete();
        });
    }
}
