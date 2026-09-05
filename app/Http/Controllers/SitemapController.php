<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Property;
use Illuminate\Http\Response;

/**
 * XML sitemap, added 2026-09-03 — the site had none, so search engines had
 * no listing-level entry point beyond whatever they happened to crawl.
 *
 * Generated on request rather than written to disk: listing volume is small
 * (tens, not tens of thousands), and a generated route can never go stale
 * after someone adds a property through the CMS.
 */
class SitemapController extends Controller
{
    /** Static routes, with a rough change frequency and relative priority. */
    private const STATIC_PAGES = [
        ['home', 'weekly', '1.0'],
        ['properties', 'daily', '0.9'],
        ['services', 'monthly', '0.8'],
        ['about', 'monthly', '0.7'],
        ['team', 'monthly', '0.6'],
        ['contact', 'monthly', '0.6'],
        ['inquiry', 'monthly', '0.6'],
        ['updates', 'weekly', '0.5'],
        ['terms', 'yearly', '0.2'],
        ['privacy', 'yearly', '0.2'],
    ];

    public function __invoke(): Response
    {
        $urls = [];

        foreach (self::STATIC_PAGES as [$routeName, $frequency, $priority]) {
            $urls[] = [
                'loc' => route($routeName),
                'changefreq' => $frequency,
                'priority' => $priority,
            ];
        }

        Property::query()
            ->where('is_available', true)
            ->orderByDesc('updated_at')
            ->get(['slug', 'updated_at'])
            ->each(function (Property $property) use (&$urls) {
                $urls[] = [
                    'loc' => route('property.view', $property->slug),
                    'lastmod' => optional($property->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            });

        Announcement::query()
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->get(['id', 'updated_at'])
            ->each(function (Announcement $announcement) use (&$urls) {
                $urls[] = [
                    'loc' => route('updates.show', $announcement->id),
                    'lastmod' => optional($announcement->updated_at)->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            });

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
