<?php

use App\Models\Announcement;
use App\Models\AnnouncementImage;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Renders every authenticated CMS screen against a real database. Added
 * 2026-09-03 after a missing `x-ui.select` component and an undefined
 * `$item['match']` array key were each 500-ing multiple CMS pages with
 * nothing in the suite to catch it.
 */
beforeEach(function () {
    Storage::fake('public');

    $this->user = User::create(['role' => 'super_admin',
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->property = Property::create([
        'title' => 'Office Space on Kamuzu Procession',
        'description' => 'Ground floor retail and office space.',
        'category' => 'Commercial',
        'type' => 'Office',
        'price' => 1200000,
        'currency' => 'MWK',
        'location' => 'Blantyre CBD',
        'status' => 'For Rent',
        'features' => ['Parking'],
        'featured_image' => 'precious-real-estate/properties/gallery/fake',
    ]);

    $this->announcement = Announcement::create([
        'title' => 'Valuation fees updated for 2026',
        'summary' => 'New schedule effective immediately.',
        'content' => '<p>Full details.</p>',
        'status' => 'published',
        'published_at' => now(),
    ]);

    $this->service = Service::create([
        'title' => 'Property Valuation',
        'short_description' => 'RICS Red Book compliant valuations.',
        'visible' => true,
    ]);

    $this->teamMember = TeamMember::create(['name' => 'Doreen Mpunga', 'role' => 'Compliance and IT']);

    $this->inquiry = Inquiry::create([
        'name' => 'Thoko Banda',
        'email' => 'thoko@example.com',
        'phone' => '0888000000',
        'type' => 'Property Valuation',
        'message' => json_encode(['service' => 'Property Valuation', 'serviceFields' => ['propertyType' => 'House']]),
        'property_id' => $this->property->id,
    ]);
});

function asAdmin(): \Tests\TestCase
{
    return test()->actingAs(test()->user)->withSession(['cms_authenticated' => true]);
}

test('every CMS index and create screen renders', function () {
    $routes = [
        'cms.dashboard',
        'cms.properties.index',
        'cms.properties.create',
        'cms.services.index',
        'cms.services.create',
        'cms.inquiries.index',
        'cms.announcements.index',
        'cms.announcements.create',
        'cms.team-members.index',
        'cms.team-members.create',
        'cms.contact.index',
        'cms.analytics.index',
        'cms.settings.index',
    ];

    foreach ($routes as $routeName) {
        asAdmin()->get(route($routeName))->assertOk();
    }
});

test('every CMS edit screen renders', function () {
    asAdmin()->get(route('cms.properties.edit', $this->property))->assertOk();
    asAdmin()->get(route('cms.announcements.edit', $this->announcement))->assertOk();
    asAdmin()->get(route('cms.team-members.edit', $this->teamMember))->assertOk();
    asAdmin()->get(route('cms.inquiries.show', $this->inquiry))->assertOk();
    asAdmin()->get(route('cms.services.edit', ['slug' => str($this->service->title)->slug()]))->assertOk();
});

test('an announcement can be created with a cover and gallery images', function () {
    asAdmin()->post(route('cms.announcements.store'), [
        'title' => 'PREC joins the Surveyors Institute review panel',
        'summary' => 'Short summary.',
        'content' => '<p>Body copy with <strong>markup</strong>.</p><script>alert(1)</script>',
        'status' => 'published',
        'cover_image' => UploadedFile::fake()->image('cover.jpg'),
        'gallery' => [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')],
    ])->assertRedirect(route('cms.announcements.index'));

    $announcement = Announcement::where('title', 'like', 'PREC joins%')->firstOrFail();

    expect($announcement->cover_image)->not->toBeNull();
    expect($announcement->images)->toHaveCount(2);
    expect($announcement->content)->toContain('<strong>');
    expect($announcement->content)->not->toContain('<script>');
});

test('settings actually persist', function () {
    asAdmin()->put(route('cms.settings.update'), [
        'system_email' => 'info@preciousrealestate.mw',
        'timezone' => 'Africa/Blantyre',
        'inquiry_email_destination' => 'info@preciousrealestate.mw',
        'default_property_status' => 'For Sale',
        'session_timeout_minutes' => 60,
    ])->assertRedirect();

    expect(Setting::where('key', 'system_email')->value('value'))->toBe('info@preciousrealestate.mw');
    expect(Setting::where('key', 'default_property_status')->value('value'))->toBe('For Sale');
});

test('the password change flow works and rejects a wrong current password', function () {
    asAdmin()->put(route('cms.settings.password'), [
        'current_password' => 'wrong-password',
        'password' => 'a-much-longer-password',
        'password_confirmation' => 'a-much-longer-password',
    ])->assertSessionHasErrors('current_password');

    asAdmin()->put(route('cms.settings.password'), [
        'current_password' => 'password',
        'password' => 'a-much-longer-password',
        'password_confirmation' => 'a-much-longer-password',
    ])->assertSessionHasNoErrors();

    expect(Hash::check('a-much-longer-password', $this->user->fresh()->password))->toBeTrue();
});

test('the CMS login throttles repeated failures', function () {
    foreach (range(1, 5) as $ignored) {
        $this->post(route('cms.login.submit'), [
            'email' => 'admin@example.com',
            'password' => 'not-the-password',
        ]);
    }

    $this->post(route('cms.login.submit'), [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertSessionHasErrors('login');

    expect(auth()->check())->toBeFalse();
});

test('deleting an announcement removes its gallery rows', function () {
    AnnouncementImage::create([
        'announcement_id' => $this->announcement->id,
        'image_path' => 'precious-real-estate/announcements/gallery/fake',
        'sort_order' => 0,
    ]);

    asAdmin()->delete(route('cms.announcements.destroy', $this->announcement))->assertRedirect();

    expect(AnnouncementImage::count())->toBe(0);
});

/**
 * 2026-09-06: GET /cms/team-members/6 (no /edit) 500'd with a raw
 * MethodNotAllowedHttpException — that URI only had PUT/DELETE registered.
 * Same gap existed for properties and announcements. Fixed by redirecting
 * the bare URL to the edit form (there's no separate read-only "view"
 * screen in this CMS) rather than assuming nobody would ever land there.
 */
test('visiting a bare CMS resource URL redirects to its edit form', function () {
    asAdmin()->get('/cms/properties/'.$this->property->id)
        ->assertRedirect(route('cms.properties.edit', $this->property));

    asAdmin()->get('/cms/announcements/'.$this->announcement->id)
        ->assertRedirect(route('cms.announcements.edit', $this->announcement));

    asAdmin()->get('/cms/team-members/'.$this->teamMember->id)
        ->assertRedirect(route('cms.team-members.edit', $this->teamMember));
});

test('a method mismatch on a real route shows a friendly redirect, not a raw exception page', function () {
    // PATCH isn't registered on this URI (only GET/PUT/DELETE are) — this
    // is the fallback for whatever bare-method mismatch isn't covered by
    // an explicit fix like the test above.
    asAdmin()->patch('/cms/properties/'.$this->property->id)
        ->assertRedirect(route('cms.dashboard'))
        ->assertSessionHas('error');
});
