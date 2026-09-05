<?php

use App\Models\Announcement;
use App\Models\Property;

/**
 * Guards the SEO work added 2026-09-03. Before it, the layout emitted a bare
 * <title> and nothing else — no description, no Open Graph tags, no sitemap,
 * no structured data — so a property link shared on WhatsApp or Facebook
 * rendered with no preview image and no text at all.
 */
beforeEach(function () {
    $this->property = Property::create([
        'title' => 'Executive Villa in Area 43',
        'description' => 'Spacious four bedroom villa with a borehole and staff quarters.',
        'category' => 'Residential',
        'type' => 'House',
        'price' => 250000000,
        'currency' => 'MWK',
        'location' => 'Area 43, Lilongwe',
        'status' => 'For Sale',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'features' => ['Borehole'],
        'featured_image' => 'precious-real-estate/properties/gallery/fake',
        'is_available' => true,
    ]);

    $this->announcement = Announcement::create([
        'title' => 'Q3 market commentary',
        'summary' => 'Where Lilongwe rents moved this quarter.',
        'content' => '<p>Full commentary.</p>',
        'status' => 'published',
        'published_at' => now(),
    ]);
});

test('every public page carries a description, canonical and Open Graph tags', function () {
    foreach (['home', 'about', 'properties', 'services', 'contact', 'team'] as $routeName) {
        $response = $this->get(route($routeName));

        $response->assertOk();
        $response->assertSee('<meta name="description"', escape: false);
        $response->assertSee('<link rel="canonical"', escape: false);
        $response->assertSee('property="og:title"', escape: false);
        $response->assertSee('property="og:image"', escape: false);
        $response->assertSee('name="twitter:card"', escape: false);
    }
});

test('a property page describes itself rather than reusing the site default', function () {
    $response = $this->get(route('property.view', $this->property->slug));

    $response->assertOk();
    $response->assertSee('Spacious four bedroom villa', escape: false);
    $response->assertSee('"@type":"RealEstateListing"', escape: false);
    $response->assertSee('"priceCurrency":"MWK"', escape: false);
});

test('organisation structured data is present site-wide', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('"@type":"RealEstateAgent"', escape: false)
        ->assertSee('Precious Real Estate Consulting', escape: false);
});

test('the sitemap lists static pages, listings and published articles', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    $response->assertSee(route('home'), escape: false);
    $response->assertSee(route('property.view', $this->property->slug), escape: false);
    $response->assertSee(route('updates.show', $this->announcement->id), escape: false);
});

test('the sitemap hides unavailable listings and unpublished articles', function () {
    $hidden = Property::create([
        'title' => 'Withdrawn Listing',
        'description' => 'No longer on the market.',
        'type' => 'Plot',
        'price' => 1000000,
        'currency' => 'MWK',
        'location' => 'Mzuzu',
        'status' => 'For Sale',
        'featured_image' => 'precious-real-estate/properties/gallery/fake',
        'is_available' => false,
    ]);

    $draft = Announcement::create([
        'title' => 'Unpublished draft',
        'status' => 'draft',
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertDontSee(route('property.view', $hidden->slug), escape: false);
    $response->assertDontSee(route('updates.show', $draft->id), escape: false);
});

test('robots.txt points at the sitemap and excludes the CMS', function () {
    $robots = file_get_contents(public_path('robots.txt'));

    expect($robots)->toContain('Sitemap: https://preciousrealestate.mw/sitemap.xml');
    expect($robots)->toContain('Disallow: /cms');
});
