# Updates Page Redesign — Design

**Date:** 2026-09-08
**Repo:** `precious-real-estate-web`
**Status:** Approved by Comfort, ready for implementation plan.

## Context

The `/updates` page (`UpdatesController`, `Announcement` model) currently
renders: a full-width featured card on top, then a single stacked column of
regular cards next to a sticky sidebar (category filter + contact card).
Categories are `['Announcement', 'Market Update', 'Notice']`. Every card and
the detail page (`updates-show.blade.php`) look identical regardless of
category — only badge text changes. Gallery images beyond the cover
(`AnnouncementImage`) are dumped in a uniform square grid after all the
article text on the detail page.

Comfort asked for: a hero row (featured item + sidebar, equal height) above a
full-width 3-column grid; new categories `Announcement / News / Blog` (Blog
being the team's own project write-ups); a distinct card design and detail
layout per category; and every post always carrying at least one image, with
extra images distributed through the reading experience rather than dumped
at the end. Confirmed via Q&A before writing this doc.

## 1. Data model changes

- `Announcement::CATEGORIES` → `['Announcement', 'News', 'Blog']` (was
  `['Announcement', 'Market Update', 'Notice']`).
- New migration: `announcements.team_member_id`, nullable `foreignId`
  constrained to `team_members`, `nullOnDelete()`. Byline for Blog posts —
  not category-restricted at the DB level (harmless if set on other
  categories, CMS just presents it as optional for all).
- `Announcement` model: add `teamMember()` belongsTo relation, add
  `team_member_id` to `$fillable`.
- No DB change for `cover_image` — it stays nullable at the column level
  (existing published rows must keep rendering even if this rule tightens
  later). Enforcement is at the CMS validation layer only: `cover_image`
  becomes `required` on create. On edit, required only if the record has no
  existing cover image yet (same `featuredRequired` pattern already used by
  `PropertiesController`).

## 2. `/updates` index layout (`updates-list.blade.php`)

Restructure from one continuous two-column layout into two stacked rows:

- **Row 1** — CSS grid, two columns (roughly 65/35, matching the current
  `[1.1fr_0.9fr]` split), `items-stretch` so both children fill to the same
  height with no JS measurement needed (this isn't an overlapping-element
  case like the properties-page hero fix — it's a normal grid row, so pure
  CSS suffices). Left: the featured/pinned article, styled as a larger
  version of its own category's card treatment (see §3) — not a 4th style.
  Right: the existing sidebar (category filter + contact card), unchanged
  except it no longer needs its own `lg:sticky` positioning since it's now
  scoped to one row instead of running the full page height.
- **Row 2** — full-width, no sidebar alongside it. Responsive grid: 1 column
  mobile, 2 tablet, 3 desktop (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`).
  Up to 9 cards (`UpdatesController::index()` already paginates at 9 — no
  controller change needed here). Pagination links render full-width below
  the grid.
- When a category filter is active, Row 1's featured slot is already
  suppressed by existing controller logic (`$featured` only populates on the
  unfiltered view) — the filtered view just shows Row 2's grid next to
  nothing in Row 1's left slot; simplest handling is to skip rendering Row 1
  entirely when `$featured` is null and a category filter is active, falling
  straight to Row 2, so the sidebar doesn't render orphaned at fixed height
  with no card beside it.

## 3. Card design per category (tone-driven)

One shared card component, `x-updates.update-card`, taking `$announcement`
and rendering different treatment by `$announcement->category`:

- **Announcement**: `bg-brand-black` card, white/primary text, bold
  `bg-primary text-brand-black` badge, cover image with a dark gradient
  overlay behind the title. Reads urgent/official.
- **News**: white card with border (matches current card style), small
  date-forward eyebrow line above the title (e.g. `NEWS · Sep 8, 2026`),
  subtler badge (`bg-primary/40` outline-style, as today). Reads
  brief/informational.
- **Blog**: white card, image-dominant (taller image ratio than the other
  two, e.g. `aspect-[4/3]` vs `aspect-video`), byline strip at the bottom —
  team member avatar (small circle, falls back to initials if no
  `photo_url`) + name + role — shown only if `team_member_id` is set. Reads
  editorial/warm.

The featured card in Row 1 reuses this same component at a larger size
(bigger image, larger heading) rather than a separate template.

## 4. Detail page per category (`updates-show.blade.php`)

Split into two templates via a category check, sharing one base shell (back
link, badge+date row, H1, cover image hero):

- **Announcement & News** (same shorter-form template): cover hero →
  content (`prose`, unchanged) → if gallery images exist, a small end-strip
  of thumbnails (current grid, just visually tightened — a 2-paragraph
  notice doesn't have enough reading length to interleave images into
  without looking sparse or forced).
- **Blog** (richer template): cover hero → byline block right under the H1
  (team member photo + name + role, "Posted by") → content with gallery
  images **auto-interleaved** between paragraphs as the reader scrolls,
  instead of a same-height end-of-article grid.
  - Interleaving implementation: split `$article->content` on `</p>`
    boundaries (content is sanitized to a fixed allowlist that includes
    `<p>`, so this is a reliable split point for staff-authored rich text).
    Walk the paragraph chunks; after every 2nd paragraph, if a gallery image
    remains unused, inject a full-bleed `<figure>` image block between
    chunks. Stop once the gallery is exhausted; any remaining paragraphs
    render normally. This lives in a small helper (e.g.
    `Announcement::interleavedContent(): array` returning an ordered list of
    `['type' => 'html'|'image', 'value' => ...]` blocks) rather than
    inline Blade logic, so it's independently testable.

## 5. CMS changes

- `resources/views/cms/announcements/{create,edit}.blade.php`: category
  dropdown needs no change (already loops `Announcement::CATEGORIES`, picks
  up the new values automatically). Add one new field: "Posted By"
  `<select>` of `TeamMember::ordered()->get()`, optional, stored as
  `team_member_id`. `cover_image` input becomes required on the create form
  (existing `<x-cms.image-upload>` component, just drop the `nullable` half
  of validation).
- `AnnouncementsController@store`/`update`: add `team_member_id` to
  validation (`nullable|exists:team_members,id`) and to the saved data;
  tighten `cover_image` validation on `store()` to `required|image|...`.

## 6. Sample data

`AnnouncementSeeder` gets rewritten: wipe the 6 existing posts (old
category values no longer valid), reseed fresh across all three categories
— at least 2 Announcement, 2 News, 2–3 Blog (one Blog post assigned a
`team_member_id`, with 3–4 gallery images so the interleaving is visible on
a real page rather than a placeholder). Cover/gallery images are run through
`MediaService::upload()` from existing files already in
`public/brand-assets/` (via a faked `UploadedFile` wrapping a real file
path) rather than left blank, so the "always has an image" rule is
demonstrated with real, working image variants — not gray placeholder boxes.

## Out of scope

- Rich-text inline image insertion in the CMS editor (staff manually
  choosing exact in-body placement) — the auto-interleave approach covers
  the "distributed while reading" requirement without new editor work.
- Any change to the `/updates` route structure, `UpdatesController::show()`
  query logic, or the existing `Announcement::sanitizeContent()` allowlist.
- Masonry/varied-size end-of-article galleries for Announcement/News — kept
  as a simple thumbnail strip since those categories are short-form by
  design.
