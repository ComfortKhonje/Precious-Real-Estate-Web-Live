# PREC CMS/Site Cleanup & Feature Pass — Design

**Date:** 2026-09-04
**Repo:** `precious-real-estate-web`
**Status:** Approved by Comfort, ready for implementation plan.

## Context

Following the 2026-09-03 full audit (all 9 runtime defects fixed, 55 tests
passing) and the 2026-09-04 environment bring-up (found and fixed a
migration-ordering bug — see project status doc), Comfort asked for a
functionality + cleanup pass across both the public site and the CMS before
further testing. This spec covers six related but independently-shippable
pieces of work, all confirmed with Comfort via Q&A before writing this doc.

## 1. Property Location Details

**Problem:** `resources/views/pages/property-details.blade.php`'s "Location
Details" section is 100% hardcoded — every property, regardless of actual
location, shows the same paragraph ("Located in one of Lilongwe's
established residential areas...") and the same fixed five-item list
(Schools, Shopping centers, Restaurants, Health facilities, Main road
networks).

**Fix:**
- New migration: add `nearby_amenities` (JSON, nullable) to `properties`,
  positioned after the existing `features` column. Mirrors that column's
  shape exactly (both are staff-entered comma-separated lists cast to array).
- `Property` model: add `nearby_amenities` to `$fillable` and to `$casts` as
  `'array'`.
- CMS create/edit forms (`resources/views/cms/properties/{create,edit}.blade.php`):
  new "Nearby Amenities" text input, comma-separated, same placeholder/help
  style as the existing "Features" field (`e.g., Solar, Water tank...`).
- `App\Http\Controllers\Cms\PropertiesController`: add
  `nearbyAmenitiesFromInput(Request $request): array`, a direct copy of the
  existing `featuresFromInput()` pattern. Wire into both `store()` and
  `update()`.
- Public property page: replace the hardcoded paragraph + `$locations` array
  with real data. Intro sentence becomes dynamic (references
  `$property->location`), amenity list renders from
  `$property->nearby_amenities`. **If empty, the whole section is hidden** —
  no placeholder/fake content ever shown to a site visitor.

## 2. News/Updates Consolidation

**Problem:** Two separate nav items point at two separate implementations of
the same concept. `/updates` (`UpdatesController`, invokable, static view)
has the nicer two-column layout but 3 hardcoded "Coming soon" entries with
zero real data behind them. `/news` (`NewsController`, real
`Announcement`-backed, paginated, has a featured-article block) has a
plainer dark-hero layout. Footer and homepage already link to `/updates`
only — `/news` is reachable only via the nav item and direct link.

**Fix (confirmed: keep `/updates` URL, delete `/news`):**
- Delete: `app/Http/Controllers/NewsController.php`, routes `/news` and
  `/news/{id}`, `resources/views/news/index.blade.php`,
  `resources/views/news/show.blade.php`.
- `UpdatesController` becomes a real controller (not `__invoke`-only):
  - `index()`: the exact query `NewsController::index()` used to run
    (`Announcement::published()->orderBy('published_at','desc')->paginate(9)`
    + featured lookup).
  - `show($id)`: same lookup `NewsController::show()` used to do.
- New route `GET /updates/{id}` → `UpdatesController@show`, named
  `updates.show`.
- `resources/views/components/updates/updates-list.blade.php`: rewritten to
  accept real `$news`/`$featured` props (replacing the hardcoded `$updates`
  array), keeping the current two-column layout (article list left,
  static "What our announcements entail" info panel right — that panel's
  copy is general company messaging, not fake data, so it stays as-is).
- New article-detail view at `resources/views/pages/updates-show.blade.php`,
  content/logic ported from the old `news/show.blade.php` but restyled to
  match the Updates page's visual language (cream background accents,
  rounded-2rem cards, primary-yellow badges) instead of the News page's dark
  hero treatment.
- Redirects: `Route::redirect('/news', '/updates', 301)` and
  `Route::get('/news/{id}', fn ($id) => redirect()->route('updates.show',
  $id, 301))` — the live site has been indexed since June, so old links
  (including ones already in the current sitemap) must not 404.
- `app/Http/Controllers/SitemapController.php`: swap the `news.index`/
  `news.show` entries for `updates`/`updates.show`.
- `resources/views/components/shared/navbar.blade.php`: remove the "News"
  nav item entirely; "Updates" stays.
- `resources/views/components/updates/page-hero.blade.php`: subhead
  currently reads as an internal dev note ("This page gives PREC a proper
  frontend destination for announcement content managed in the CMS, while
  staying clean and easy for clients to scan.") — replace with real
  visitor-facing copy.

## 3. Announcement Categories

**Problem:** The fake Updates data had per-item category badges
(Announcement/News/Update). The real `Announcement` model has no equivalent
field — only `status` and `is_featured`.

**Fix:**
- New migration: add `category` (string, nullable) to `announcements`.
- `Announcement` model: add `category` to `$fillable`; add constant
  `CATEGORIES = ['Announcement', 'Market Update', 'Notice']`.
- CMS announcement create/edit forms: category `<select>` using that
  constant, same dropdown pattern as `Property::TYPES`/`Property::STATUSES`
  elsewhere in the codebase.
- Public updates list/detail: badge renders `$article->category`, falling
  back to `'Update'` if null (covers rows created before this migration).

## 4. CMS Tab Cleanup

**Problem A — dead stub:** `/cms/featured` (sidebar: "Featured Properties")
is a bare closure returning a static view. It always renders "No featured
properties" regardless of real data and its "drag and drop ordering" is
explicitly commented as a non-functional stub. Meanwhile the property
create/edit form already has a working `is_featured` checkbox
(`PropertiesController` persists it correctly) — the standalone tab
duplicates nothing real.

**Fix:** delete the route (`cms.featured.index`), the view
(`resources/views/cms/featured/index.blade.php`), and its sidebar entry in
`resources/views/layouts/cms.blade.php`. Featuring a property stays exactly
where it already works.

**Problem B — orphaned functional page:** `/cms/analytics` is fully wired to
real data (`Inquiry`, `PageView`, `Property` counts) but has no sidebar link
in `layouts/cms.blade.php` — reachable only by typing the URL directly.

**Fix:** add an "Analytics" entry to the sidebar nav array, positioned right
after "Dashboard Overview".

## 5. Contact Info — Single Source of Truth

**Problem:** The CMS "Contact Information" tab already writes real values to
the `Setting` key/value table (`office_phone`, `office_email`,
`office_address`, `facebook_url`, `instagram_url`, `linkedin_url`,
`whatsapp_number`, etc. — `Cms\ContactController` is fully functional) but
**nothing on the public site reads any of it.** Phone/email/address are
hardcoded independently in at least: `shared/contact-info.blade.php`,
`pages/property-details.blade.php` (two `tel:`/`mailto:` buttons), and the
Facebook icon in `shared/footer.blade.php`. Editing the dashboard currently
changes nothing a visitor sees.

**Gap found during scoping:** the `Setting` schema has one address field,
but the real business has two physical offices (Lilongwe + Blantyre), both
shown today in the hardcoded copy. Confirmed fix: model both explicitly.

**Fix:**
- Extend `Cms\ContactController`'s managed keys: replace the single
  `office_address` concept with `office_address_lilongwe` and
  `office_address_blantyre`. Update `cms.contact.index` view with both
  fields, clearly labeled.
- New `App\Support\ContactInfo` static helper class, methods: `phone()`,
  `email()`, `addressLilongwe()`, `addressBlantyre()`, `workingHours()`,
  `whatsapp()`, `facebookUrl()`, `instagramUrl()`, `linkedinUrl()`. Each
  reads the corresponding `Setting` row and falls back to the current
  hardcoded value as a default if the setting has never been saved — so
  this ships with zero visual change until Comfort actually edits something
  in the CMS.
- Update `shared/contact-info.blade.php`, `pages/property-details.blade.php`,
  and `shared/footer.blade.php` to call `ContactInfo::` instead of hardcoding
  literals.
- Footer gains conditional Instagram/LinkedIn/WhatsApp icons (rendered only
  when `ContactInfo::` returns a non-null value) — these `Setting` keys
  already exist and are already saved by the Contact Information form, just
  never displayed anywhere until now.
- Legal pages (`components/legal/{privacy,terms}-content.blade.php`) get the
  same literal-to-helper swap wherever they reference the phone/email
  directly, so those two also stay in sync.

## 6. UI Polish

**Image/media upload preview:**
- New reusable Blade+Alpine component, `<x-cms.image-upload>`, replacing the
  current no-feedback file inputs:
  - Property create/edit: featured image + gallery inputs currently render
    an invisible (`opacity-0`) overlay input with no preview at all after a
    file is chosen.
  - Announcement create/edit: cover image + gallery inputs, same gap.
  - Team member create/edit: existing preview logic is bound to a **URL text
    field**, not an actual selected file — gets aligned to the same
    component so it previews whatever image is actually picked.
- Behavior: instant thumbnail via `FileReader` on selection, multi-file
  grid for galleries, a remove button per thumbnail before submit. Existing
  already-saved images (edit forms) continue to show as they do today —
  this only fixes the newly-selected-file feedback gap.

**Quill editor reskin:**
- `resources/js/cms-editor.js` currently uses Quill's stock "snow" theme
  CSS unmodified — plain gray toolbar, default system font, no brand
  presence, visually inconsistent with the rest of the CMS's rounded-3xl /
  primary-yellow / Barlow-Outfit design language.
- Add a CSS override (new partial imported from `resources/css/app.css`)
  targeting Quill's toolbar and editor classes: rounded-2xl toolbar
  container, Outfit for editor body text, primary-yellow active/hover state
  on toolbar buttons, brand-black icon strokes. No changes to
  `cms-editor.js`'s functional behavior (toolbar options, sanitization
  boundary) — visual only.

## Ordering

1. CMS tab cleanup (§4) — smallest, zero data-model risk.
2. Contact info (§5) — schema tweak + helper class, self-contained.
3. Property location details (§1) — new column, form field, display fix.
4. Announcement categories (§3) — small, needed before §2/news merge's
   display logic references it.
5. News/Updates consolidation (§2) — largest single piece, benefits from
   categories already existing.
6. UI polish (§6) — depends on nothing above; done last.

## Out of scope

- No redesign of the property type/category/status taxonomy.
- No change to the `property_images` vs `gallery` JSON column question
  flagged in the 2026-09-01 audit (#13) — untouched here.
- No real drag-and-drop reordering anywhere (the Featured Properties stub is
  removed, not rebuilt).
- SLA/billing question (is this in-scope for the free support window closing
  2026-09-20?) — still Comfort's call, not addressed by this spec.
