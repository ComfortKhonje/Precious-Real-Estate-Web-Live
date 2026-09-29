<?php

use App\Models\Announcement;
use App\Models\AnnouncementImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Update form flow (2026-09-29): event dates, gallery add/remove, and the
 * public article page that shows them.
 */
beforeEach(function () {
    Storage::fake('public');

    $this->editor = User::create([
        'role' => 'editor',
        'name' => 'Editor',
        'email' => 'editor@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->announcement = Announcement::create([
        'title' => 'Open house in Area 47',
        'summary' => 'Three days of viewings.',
        'content' => '<p>First paragraph.</p><ol><li data-list="bullet">Point one</li></ol>',
        'cover_image' => 'precious-real-estate/announcements/featured/fake',
        'status' => 'published',
        'published_at' => now(),
    ]);
});

function asEditor(): \Tests\TestCase
{
    return test()->actingAs(test()->editor)->withSession(['cms_authenticated' => true]);
}

function updatePayload(array $overrides = []): array
{
    return array_merge([
        'title' => 'Open house in Area 47',
        'status' => 'published',
    ], $overrides);
}

test('event dates are saved and shown as a compact range', function () {
    asEditor()->put(route('cms.announcements.update', $this->announcement), updatePayload([
        'event_start_date' => '2026-09-12',
        'event_end_date' => '2026-09-14',
    ]))->assertRedirect(route('cms.announcements.index'));

    $this->announcement->refresh();
    expect($this->announcement->eventDateRange())->toBe('12–14 Sep 2026');

    $this->get(route('updates.show', $this->announcement->id))
        ->assertOk()
        ->assertSee('12–14 Sep 2026')
        ->assertSee('Three days of viewings.');

    $this->get(route('updates'))->assertSee('12–14 Sep 2026');
});

test('an end date on its own is stored as a single-day event', function () {
    asEditor()->put(route('cms.announcements.update', $this->announcement), updatePayload([
        'event_end_date' => '2026-10-03',
    ]))->assertSessionHasNoErrors();

    $this->announcement->refresh();
    expect($this->announcement->event_start_date->toDateString())->toBe('2026-10-03');
    expect($this->announcement->event_end_date)->toBeNull();
    expect($this->announcement->eventDateRange())->toBe('3 Oct 2026');
});

test('an end date before the start date is rejected', function () {
    asEditor()->put(route('cms.announcements.update', $this->announcement), updatePayload([
        'event_start_date' => '2026-09-14',
        'event_end_date' => '2026-09-12',
    ]))->assertSessionHasErrors('event_end_date');
});

test('event ranges across months and years read naturally', function () {
    $a = new Announcement(['event_start_date' => '2026-09-28', 'event_end_date' => '2026-10-02']);
    expect($a->eventDateRange())->toBe('28 Sep – 2 Oct 2026');

    $a = new Announcement(['event_start_date' => '2026-12-30', 'event_end_date' => '2027-01-02']);
    expect($a->eventDateRange())->toBe('30 Dec 2026 – 2 Jan 2027');

    expect((new Announcement)->eventDateRange())->toBeNull();
});

test('gallery images marked for removal are deleted and new ones are added', function () {
    $keep = AnnouncementImage::create(['announcement_id' => $this->announcement->id, 'image_path' => 'precious-real-estate/announcements/gallery/keep', 'sort_order' => 0]);
    $drop = AnnouncementImage::create(['announcement_id' => $this->announcement->id, 'image_path' => 'precious-real-estate/announcements/gallery/drop', 'sort_order' => 1]);

    asEditor()->put(route('cms.announcements.update', $this->announcement), updatePayload([
        'remove_images' => [$drop->id],
        'gallery' => [UploadedFile::fake()->image('new.jpg')],
    ]))->assertRedirect(route('cms.announcements.index'));

    $ids = $this->announcement->images()->pluck('id');
    expect($ids)->toContain($keep->id)->not->toContain($drop->id);
    expect($ids)->toHaveCount(2);
});

test('the edit form lists saved gallery images with a remove control', function () {
    $image = AnnouncementImage::create(['announcement_id' => $this->announcement->id, 'image_path' => 'precious-real-estate/announcements/gallery/one', 'sort_order' => 0]);

    asEditor()->get(route('cms.announcements.edit', $this->announcement))
        ->assertOk()
        ->assertSee('Remove this image')
        // Saved images reach Alpine through @js(), where each "/" is written as \\\/.
        ->assertSee(str_replace('/', '\\\\\\/', $image->image_path.'/thumbnail.webp'), escape: false)
        ->assertSee('Event Dates');
});

test('the article page shows Quill bullet lists and a reading time', function () {
    $this->get(route('updates.show', $this->announcement->id))
        ->assertOk()
        ->assertSee('data-list="bullet"', escape: false)
        ->assertSee('article-prose', escape: false)
        ->assertSee('1 min read');
});

/*
 * Production 500 on 2026-09-29: a 330-character summary passed `max:500`
 * validation but the column was VARCHAR(255). SQLite doesn't enforce VARCHAR
 * lengths, so check the column types themselves.
 */
test('summary columns hold everything validation allows', function () {
    expect(\Illuminate\Support\Facades\Schema::getColumnType('announcements', 'summary'))->toBe('text');
    expect(\Illuminate\Support\Facades\Schema::getColumnType('services', 'short_description'))->toBe('text');
});

test('an update with a long summary is created', function () {
    $summary = str_repeat('Precious Real Estate Consulting attended the SIM CPD Conference. ', 5);

    asEditor()->post(route('cms.announcements.store'), updatePayload([
        'title' => 'PREC Attends SIM CPD Conference 2026',
        'summary' => $summary,
        'cover_image' => UploadedFile::fake()->image('cover.jpg'),
        'event_start_date' => '2026-05-20',
        'event_end_date' => '2026-05-21',
    ]))->assertRedirect(route('cms.announcements.index'));

    $created = Announcement::where('title', 'PREC Attends SIM CPD Conference 2026')->firstOrFail();
    expect(mb_strlen($created->summary))->toBeGreaterThan(255);
    expect($created->eventDateRange())->toBe('20–21 May 2026');
});
