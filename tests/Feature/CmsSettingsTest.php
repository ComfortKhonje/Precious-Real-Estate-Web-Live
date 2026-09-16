<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::create(['role' => 'super_admin',
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
});

test('saving settings updates existing rows instead of crashing on the string primary key', function () {
    Setting::create(['key' => 'system_email', 'value' => 'old@example.com']);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->put(route('cms.settings.update'), [
            'system_email' => 'new@example.com',
            'timezone' => 'Africa/Blantyre',
        ])
        ->assertRedirect();

    expect(Setting::find('system_email')->value)->toBe('new@example.com');
    expect(Setting::find('timezone')->value)->toBe('Africa/Blantyre');
});

test('saving contact information updates an existing setting by key', function () {
    Setting::create(['key' => 'office_phone', 'value' => '+265000000000']);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->put(route('cms.contact.update'), [
            'office_phone' => '+265994818122',
        ])
        ->assertRedirect(route('cms.contact.index'));

    expect(Setting::find('office_phone')->value)->toBe('+265994818122');
});
