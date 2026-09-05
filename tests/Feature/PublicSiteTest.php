<?php

use App\Models\Announcement;
use App\Models\Property;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Every public page rendered against a real database. Before 2026-09-03 none
 * of these had ever been executed — the public /properties page in particular
 * had a paginator-vs-array bug that meant it never rendered a single listing.
 */
function seedProperty(array $overrides = []): Property
{
    return Property::create(array_merge([
        'title' => 'Three Bedroom House in Nyambadwe',
        'description' => 'Quiet neighbourhood, walled and gated.',
        'category' => 'Residential',
        'type' => 'House',
        'price' => 62000000,
        'currency' => 'MWK',
        'location' => 'Nyambadwe, Blantyre',
        'status' => 'For Sale',
        'bedrooms' => 3,
        'bathrooms' => 2,
        'parking_spaces' => 1,
        'features' => ['Borehole'],
        'featured_image' => 'precious-real-estate/properties/gallery/fake',
        'is_featured' => true,
        'is_available' => true,
    ], $overrides));
}

beforeEach(function () {
    seedProperty();

    Announcement::create([
        'title' => 'PREC opens a second Blantyre office',
        'summary' => 'More space for valuation clients.',
        'content' => '<p>Details of the move.</p>',
        'status' => 'published',
        'published_at' => now(),
    ]);

    TeamMember::create(['name' => 'Precious Tembo', 'role' => 'Managing Director', 'visible' => true]);
});

dataset('public pages', [
    'home' => ['home'],
    'about' => ['about'],
    'team' => ['team'],
    'properties' => ['properties'],
    'services' => ['services'],
    'contact' => ['contact'],
    'updates' => ['updates'],
    'terms' => ['terms'],
    'privacy' => ['privacy'],
    'credits' => ['credits'],
    'inquiry' => ['inquiry'],
]);

test('public page renders', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with('public pages');

test('the properties page actually lists properties', function () {
    $this->get(route('properties'))
        ->assertOk()
        ->assertSee('Three Bedroom House in Nyambadwe', escape: false);
});

test('a property detail page resolves by slug', function () {
    $property = Property::firstOrFail();

    $this->get(route('property.view', $property->slug))
        ->assertOk()
        ->assertSee($property->title, escape: false);
});

test('an updates article page renders', function () {
    $article = Announcement::firstOrFail();

    $this->get(route('updates.show', $article->id))->assertOk();
});

test('old /news URLs redirect to /updates', function () {
    $article = Announcement::firstOrFail();

    $this->get('/news')->assertRedirect(route('updates'));
    $this->get("/news/{$article->id}")->assertRedirect(route('updates.show', $article->id));
});

test('the properties API returns a usable payload', function () {
    $this->getJson('/api/properties')
        ->assertOk()
        ->assertJsonPath('data.0.title', 'Three Bedroom House in Nyambadwe')
        ->assertJsonPath('data.0.formatted_price', 'MWK 62,000,000');
});

test('unavailable properties never leak into the public API', function () {
    seedProperty(['title' => 'Hidden Listing', 'is_available' => false]);

    $titles = collect($this->getJson('/api/properties')->json('data'))->pluck('title');

    expect($titles)->not->toContain('Hidden Listing');
});

test('the public inquiry endpoint stores a real inquiry with its property reference', function () {
    $property = Property::firstOrFail();

    $this->postJson('/api/inquiries/public', [
        'service' => 'Property Valuation',
        'name' => 'Chikondi Phiri',
        'email' => 'chikondi@example.com',
        'phone' => '0991234567',
        'contactMethod' => 'WhatsApp',
        'property_id' => $property->id,
        'additionalDetails' => 'Please call in the afternoon.',
    ])->assertCreated();

    $inquiry = \App\Models\Inquiry::firstOrFail();

    expect($inquiry->type)->toBe('Property Valuation');
    expect($inquiry->property_id)->toBe($property->id);
});

test('the CMS is not reachable without logging in', function () {
    $this->get(route('cms.dashboard'))->assertRedirect(route('cms.login'));
    $this->get(route('cms.properties.index'))->assertRedirect(route('cms.login'));
    $this->get(route('cms.inquiries.index'))->assertRedirect(route('cms.login'));
});

test('public self-registration is gone', function () {
    $this->postJson('/api/register', [
        'name' => 'Intruder',
        'email' => 'intruder@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertNotFound();

    expect(User::where('email', 'intruder@example.com')->exists())->toBeFalse();
});

test('security headers are present on public responses', function () {
    $response = $this->get(route('home'));

    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-Frame-Options');
    $response->assertHeader('Referrer-Policy');
});

test('pageviews are recorded for public pages but not for the CMS', function () {
    $this->get(route('home'));
    $this->get(route('cms.login'));

    $paths = \App\Models\PageView::pluck('path');

    expect($paths)->toContain('/');
    expect($paths)->not->toContain('cms/login');
});
