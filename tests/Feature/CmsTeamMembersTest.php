<?php

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
});

test('authenticated user can view team members index', function () {
    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->get(route('cms.team-members.index'))
        ->assertStatus(200);
});

test('authenticated user can update a team member', function () {
    $member = TeamMember::create([
        'name' => 'John Doe',
        'role' => 'Developer',
        'bio' => 'Likes coding.',
        'photo_url' => 'https://example.com/john.jpg',
        'order' => 1,
        'visible' => true,
    ]);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->put(route('cms.team-members.update', $member), [
            'name' => 'John Updated',
            'role' => 'Lead Developer',
            'bio' => 'Likes coding a lot.',
            'order' => 2,
            'visible' => 0,
        ])
        ->assertRedirect(route('cms.team-members.index'));

    $member->refresh();

    expect($member->name)->toBe('John Updated');
    expect($member->role)->toBe('Lead Developer');
    expect($member->visible)->toBeFalse();
});

test('authenticated user can delete a team member', function () {
    $member = TeamMember::create([
        'name' => 'John Doe',
        'role' => 'Developer',
    ]);

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->delete(route('cms.team-members.destroy', $member))
        ->assertRedirect(route('cms.team-members.index'));

    expect(TeamMember::find($member->id))->toBeNull();
});

test('uploading a team member photo stores a media path', function () {
    Storage::fake('public');

    $this->actingAs($this->user)
        ->withSession(['cms_authenticated' => true])
        ->post(route('cms.team-members.store'), [
            'name' => 'Jane Doe',
            'role' => 'Valuation Officer',
            'photo_url' => UploadedFile::fake()->image('jane.jpg', 400, 400),
        ])
        ->assertRedirect(route('cms.team-members.index'));

    $member = TeamMember::where('name', 'Jane Doe')->firstOrFail();

    expect($member->photo_url)->not->toBeEmpty();
    expect(str_starts_with($member->photo_url, 'http'))->toBeFalse();
});
