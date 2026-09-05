<?php

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Runtime coverage for the 2026-09-02 property-form rebuild, which until
 * 2026-09-03 had never been executed against a real database at all.
 */
beforeEach(function () {
    Storage::fake('public');

    $this->user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
});

function validPropertyPayload(array $overrides = []): array
{
    return array_merge([
        'title' => 'Four Bedroom House in Area 47',
        'description' => 'A well finished family home close to the city centre.',
        'category' => 'Residential',
        'type' => 'House',
        'price' => 85000000,
        'currency' => 'MWK',
        'location' => 'Area 47, Lilongwe',
        'status' => 'For Sale',
        'bedrooms' => 4,
        'bathrooms' => 3,
        'land_size' => '1200 sqm',
        'parking_spaces' => 2,
        'features' => 'Borehole, Solar, Walled',
        'is_featured' => 1,
        'is_available' => 1,
    ], $overrides);
}

test('a property can actually be created through the CMS form', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->post(route('cms.properties.store'), validPropertyPayload([
            'featured_image' => UploadedFile::fake()->image('cover.jpg', 1200, 800),
            'gallery' => [
                UploadedFile::fake()->image('one.jpg', 900, 600),
                UploadedFile::fake()->image('two.jpg', 900, 600),
            ],
        ]));

    $response->assertRedirect(route('cms.properties.index'));

    $property = Property::firstOrFail();

    expect($property->slug)->toBe('four-bedroom-house-in-area-47');
    expect($property->category)->toBe('Residential');
    expect($property->parking_spaces)->toBe(2);
    expect($property->is_available)->toBeTrue();
    expect($property->features)->toBe(['Borehole', 'Solar', 'Walled']);
    expect($property->featured_image)->not->toBeNull();
    expect($property->images)->toHaveCount(3);
    expect($property->images()->where('is_featured', true)->count())->toBe(1);
});

test('slugs stay unique when two properties share a title', function () {
    foreach (range(1, 2) as $i) {
        $this->actingAs($this->user)
            ->withSession(['cms_authenticated' => true])
            ->post(route('cms.properties.store'), validPropertyPayload([
                'featured_image' => UploadedFile::fake()->image("cover{$i}.jpg"),
            ]))
            ->assertRedirect(route('cms.properties.index'));
    }

    expect(Property::pluck('slug')->all())
        ->toBe(['four-bedroom-house-in-area-47', 'four-bedroom-house-in-area-47-2']);
});

test('editing a property saves every field and never changes the slug', function () {
    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->post(route('cms.properties.store'), validPropertyPayload([
            'featured_image' => UploadedFile::fake()->image('cover.jpg'),
        ]));

    $property = Property::firstOrFail();
    $originalSlug = $property->slug;

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->put(route('cms.properties.update', $property), validPropertyPayload([
            'title' => 'Renamed Listing',
            'status' => 'For Rent',
            'price' => 450000,
            'parking_spaces' => 5,
            'is_available' => 0,
        ]))
        ->assertRedirect(route('cms.properties.index'));

    $property->refresh();

    expect($property->title)->toBe('Renamed Listing');
    expect($property->slug)->toBe($originalSlug);
    expect($property->status)->toBe('For Rent');
    expect($property->parking_spaces)->toBe(5);
    expect($property->is_available)->toBeFalse();
    expect($property->formatted_price)->toBe('MWK 450,000 / month');
});

test('a rogue status value is rejected instead of silently corrupting the row', function () {
    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->post(route('cms.properties.store'), validPropertyPayload([
            'status' => 'Sold',
            'featured_image' => UploadedFile::fake()->image('cover.jpg'),
        ]))
        ->assertSessionHasErrors('status');

    expect(Property::count())->toBe(0);
});

test('deleting a property removes its image rows too', function () {
    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->post(route('cms.properties.store'), validPropertyPayload([
            'featured_image' => UploadedFile::fake()->image('cover.jpg'),
            'gallery' => [UploadedFile::fake()->image('one.jpg')],
        ]));

    $property = Property::firstOrFail();
    expect(PropertyImage::count())->toBe(2);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->delete(route('cms.properties.destroy', $property))
        ->assertRedirect(route('cms.properties.index'));

    expect(Property::count())->toBe(0);
    expect(PropertyImage::count())->toBe(0);
});
