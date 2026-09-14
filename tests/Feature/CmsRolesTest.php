<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

/**
 * Roles, staff-account management, forced password changes and the
 * self-service reset flow — all added 2026-09-14 for launch.
 */
function makeUser(string $role, array $overrides = []): User
{
    return User::create(array_merge([
        'name' => ucfirst($role).' Person',
        'email' => $role.'@example.com',
        'password' => 'password',
        'role' => $role,
    ], $overrides));
}

test('an editor can manage content but not admin-only sections', function () {
    $editor = makeUser('editor');

    $this->actingAs($editor)->get(route('cms.properties.index'))->assertOk();
    $this->actingAs($editor)->get(route('cms.inquiries.index'))->assertOk();
    $this->actingAs($editor)->get(route('cms.settings.index'))->assertOk();

    $this->actingAs($editor)->get(route('cms.users.index'))->assertForbidden();
    $this->actingAs($editor)->get(route('cms.analytics.index'))->assertForbidden();
    $this->actingAs($editor)->get(route('cms.contact.index'))->assertForbidden();
    $this->actingAs($editor)->put(route('cms.settings.update'), ['system_email' => 'x@example.com'])->assertForbidden();
    $this->actingAs($editor)->post(route('cms.settings.maintenance'))->assertForbidden();
});

test('an admin can create an editor account', function () {
    $admin = makeUser('admin');

    $this->actingAs($admin)->post(route('cms.users.store'), [
        'name' => 'Doreen Mpunga',
        'email' => 'doreen@example.com',
        'role' => 'editor',
        'password' => 'a-long-enough-password',
        'must_change_password' => '1',
    ])->assertRedirect(route('cms.users.index'));

    $created = User::where('email', 'doreen@example.com')->firstOrFail();
    expect($created->role)->toBe('editor');
    expect($created->must_change_password)->toBeTrue();
});

test('an admin cannot create or touch a super admin', function () {
    $admin = makeUser('admin');
    $super = makeUser('super_admin');

    $this->actingAs($admin)->post(route('cms.users.store'), [
        'name' => 'Sneaky',
        'email' => 'sneaky@example.com',
        'role' => 'super_admin',
    ])->assertSessionHasErrors('role');

    $this->actingAs($admin)->get(route('cms.users.edit', $super))->assertForbidden();
    $this->actingAs($admin)->delete(route('cms.users.destroy', $super))->assertForbidden();
    expect($super->fresh())->not->toBeNull();
});

test('the last super admin cannot be demoted or deleted', function () {
    $super = makeUser('super_admin');
    $other = makeUser('super_admin', ['email' => 'second@example.com']);

    // Two exist: demoting one is fine.
    $this->actingAs($super)->put(route('cms.users.update', $other), [
        'name' => $other->name,
        'email' => $other->email,
        'role' => 'admin',
    ])->assertRedirect(route('cms.users.index'));

    // Now only one is left.
    $other->update(['role' => 'super_admin']);
    $other->delete();

    $this->actingAs($super)->delete(route('cms.users.destroy', $super))->assertSessionHas('error');
    expect($super->fresh())->not->toBeNull();
});

test('a generated password is shown once and forces a change at first login', function () {
    $super = makeUser('super_admin');

    $this->actingAs($super)->post(route('cms.users.store'), [
        'name' => 'Info Desk',
        'email' => 'info@example.com',
        'role' => 'admin',
        'must_change_password' => '1',
    ])->assertSessionHas('generated_password');

    // Flash data — read it before the next request consumes it.
    $generated = session('generated_password');
    $info = User::where('email', 'info@example.com')->firstOrFail();

    $this->actingAs($info)->get(route('cms.properties.index'))->assertRedirect(route('cms.settings.index'));

    $this->actingAs($info)->put(route('cms.settings.password'), [
        'current_password' => $generated,
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ]);

    expect($info->fresh()->must_change_password)->toBeFalse();
    $this->actingAs($info->fresh())->get(route('cms.properties.index'))->assertOk();
});

test('the legacy session flag alone no longer grants CMS access', function () {
    $this->withSession(['cms_authenticated' => true])
        ->get(route('cms.dashboard'))
        ->assertRedirect(route('cms.login'));
});

test('a forgot-password request emails a CMS reset link', function () {
    Notification::fake();
    $user = makeUser('editor');

    $this->post(route('cms.password.email'), ['email' => $user->email])->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $url = $notification->toMail($user)->actionUrl;

        return str_contains($url, '/cms/reset-password/');
    });
});

test('an unknown email gets the same forgot-password answer', function () {
    $this->post(route('cms.password.email'), ['email' => 'nobody@example.com'])->assertSessionHas('status');
});

test('login is also limited per IP across different emails', function () {
    foreach (range(1, 20) as $i) {
        $this->post(route('cms.login.submit'), ['email' => "guess{$i}@example.com", 'password' => 'nope']);
    }

    $user = makeUser('editor');

    $this->post(route('cms.login.submit'), ['email' => $user->email, 'password' => 'password'])
        ->assertSessionHasErrors('login');
    expect(auth()->check())->toBeFalse();
});

test('the removed API endpoints are gone', function () {
    $this->postJson('/api/login', ['email' => 'a@example.com', 'password' => 'x'])->assertNotFound();
    $this->postJson('/api/properties', ['title' => 'x'])->assertStatus(405);
    $this->getJson('/api/settings')->assertNotFound();
    $this->getJson('/api/inquiries')->assertNotFound();
});

test('post-deploy migrates, seeds an empty database and creates the first super admin once', function () {
    File::put(base_path('RELEASE'), 'test-sha-1');
    File::delete(storage_path('app/deployed-release'));

    config()->set('cms.bootstrap_admin', [
        'name' => 'Comfort',
        'email' => 'comfort@example.com',
        'password' => 'bootstrap-password-123',
    ]);

    try {
        $this->artisan('prec:post-deploy')->assertSuccessful();

        expect(User::where('email', 'comfort@example.com')->value('role'))->toBe('super_admin');
        expect(\App\Models\Service::count())->toBeGreaterThan(0);
        expect(trim(File::get(storage_path('app/deployed-release'))))->toBe('test-sha-1');

        // Second run for the same release is a no-op; bootstrap never repeats.
        User::where('email', 'comfort@example.com')->delete();
        makeUser('editor');
        File::put(base_path('RELEASE'), 'test-sha-2');
        $this->artisan('prec:post-deploy')->assertSuccessful();
        expect(User::where('email', 'comfort@example.com')->exists())->toBeFalse();
    } finally {
        File::delete(base_path('RELEASE'));
        File::delete(storage_path('app/deployed-release'));
        $this->artisan('optimize:clear');
    }
});
