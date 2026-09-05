<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
});

test('authenticated user can view services index', function () {
    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->get(route('cms.services.index'))
        ->assertStatus(200);
});

test('authenticated user can update a service', function () {
    $service = Service::create([
        'title' => 'Test Service Title',
        'short_description' => 'A test service.',
        'content' => 'Full content here.',
        'banner_image' => 'https://example.com/banner.jpg',
        'icon' => 'home',
        'visible' => true,
    ]);

    $slug = str($service->title)->slug();

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->put(route('cms.services.update', ['slug' => $slug]), [
            'title' => 'Updated Service Title',
            'short_description' => 'Updated short description.',
            'content' => 'Updated full content here.',
            'icon' => 'star',
            'visible' => 0,
        ])
        ->assertRedirect(route('cms.services.index'));

    $service->refresh();

    expect($service->title)->toBe('Updated Service Title');
    expect($service->visible)->toBeFalse();
});

test('authenticated user can delete a service', function () {
    $service = Service::create([
        'title' => 'Service to delete',
        'short_description' => 'To be deleted.',
    ]);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->delete(route('cms.services.destroy', $service))
        ->assertRedirect(route('cms.services.index'));

    expect(Service::find($service->id))->toBeNull();
});
