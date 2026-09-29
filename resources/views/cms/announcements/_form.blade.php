{{--
    Shared by create and edit (2026-09-29) — the two copies had already
    drifted (different labels, layout and help text for the same fields).
    $announcement is null on create.

    Layout: writing on the left (content, then gallery, which needs the
    width), settings on the right (publishing, cover, details), the way most
    publishing tools split it.
--}}
@php
    $a = $announcement;
    $selectedCategory = old('category', $a?->category);
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
        <p class="font-semibold">The update wasn't saved. Please fix the following:</p>
        <ul class="mt-2 list-disc pl-5 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start" x-data="{ category: @js($selectedCategory ?? '') }">

    {{-- Main column --}}
    <div class="lg:col-span-2 space-y-6">
        <section class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Content</h3>
            <p class="text-sm text-brand-black/60 mb-6">What visitors read. Keep the title short and the summary to a sentence or two.</p>

            <div class="space-y-5">
                <div class="space-y-2">
                    <label for="title" class="text-sm font-semibold tracking-wider">Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $a?->title) }}" required maxlength="255"
                        placeholder="e.g. Blantyre office closed for the public holiday"
                        class="cms-input @error('title') ring-2 ring-red-300 @enderror">
                    @error('title') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2" x-data="{ length: {{ mb_strlen((string) old('summary', $a?->summary)) }} }">
                    <div class="flex items-baseline justify-between">
                        <label for="summary" class="text-sm font-semibold tracking-wider">Short Summary</label>
                        <span class="text-xs" :class="length > 450 ? 'text-amber-600 font-semibold' : 'text-brand-black/40'" x-text="length + ' / 500'"></span>
                    </div>
                    <textarea id="summary" name="summary" rows="3" maxlength="500" x-on:input="length = $event.target.value.length"
                        placeholder="One or two sentences shown on the updates list and at the top of the post."
                        class="cms-input">{{ old('summary', $a?->summary) }}</textarea>
                    @error('summary') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Content</label>
                    <div data-quill-editor="content">
                        <textarea name="content" rows="8" placeholder="Write the full update…">{{ old('content', $a?->content) }}</textarea>
                    </div>
                    <p class="text-xs text-brand-black/50">Use headings and lists to break up long posts. Photos go in the gallery below, not in the text.</p>
                    @error('content') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        <section class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Gallery</h3>
            <p class="text-sm text-brand-black/60 mb-6">
                Optional extra photos. On Blog posts they appear between paragraphs; on News and Announcements they show as a strip after the text.
            </p>
            <x-cms.image-upload
                name="gallery[]"
                label="Gallery Images"
                :multiple="true"
                :existing="$a ? $a->images->map(fn ($image) => ['id' => $image->id, 'url' => $image->url('thumbnail')])->all() : []"
            />
        </section>
    </div>

    {{-- Side column --}}
    <div class="space-y-6">
        <section class="bg-white border border-gray-100 rounded-3xl p-6 space-y-5">
            <h3 class="font-heading text-2xl leading-none">Publishing</h3>

            <div class="space-y-2">
                <label for="status" class="text-sm font-semibold tracking-wider">Status</label>
                @php $status = old('status', $a?->status ?? 'draft'); @endphp
                <select id="status" name="status" class="cms-select">
                    <option value="draft" @selected($status === 'draft')>Draft — only visible here</option>
                    <option value="published" @selected($status === 'published')>Published — live on the site</option>
                    <option value="archived" @selected($status === 'archived')>Archived — hidden from the site</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="published_at" class="text-sm font-semibold tracking-wider">Post Date</label>
                <input type="datetime-local" id="published_at" name="published_at"
                    value="{{ old('published_at', $a?->published_at?->format('Y-m-d\TH:i')) }}"
                    class="cms-input">
                <p class="text-xs text-brand-black/50">The date shown on the post and used for ordering. Leave empty to use now.</p>
            </div>

            <div class="pt-1">
                <x-cms.toggle name="is_featured" :checked="old('is_featured', $a?->is_featured)" label="Feature at the top of the Updates page" />
            </div>
        </section>

        <section class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-2xl leading-none mb-4">Cover Image</h3>
            <x-cms.image-upload
                name="cover_image"
                label="Cover"
                :required="true"
                :current="$a?->cover_image ? $a->coverImageUrl('medium') : null"
                help="Shown on the updates list and at the top of the post"
            />
        </section>

        <section class="bg-white border border-gray-100 rounded-3xl p-6 space-y-5">
            <h3 class="font-heading text-2xl leading-none">Details</h3>

            <div class="space-y-2">
                <label for="category" class="text-sm font-semibold tracking-wider">Category</label>
                <select id="category" name="category" class="cms-select" x-model="category">
                    <option value="">No category</option>
                    @foreach (\App\Models\Announcement::CATEGORIES as $cat)
                        <option value="{{ $cat }}" @selected($selectedCategory === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2" x-show="category === 'Blog'" x-cloak>
                <label for="team_member_id" class="text-sm font-semibold tracking-wider">Posted By</label>
                <select id="team_member_id" name="team_member_id" class="cms-select">
                    <option value="">No byline</option>
                    @foreach ($teamMembers as $member)
                        <option value="{{ $member->id }}" @selected((string) old('team_member_id', $a?->team_member_id) === (string) $member->id)>{{ $member->name }} — {{ $member->role }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-brand-black/50">Shown with their photo under the title.</p>
            </div>

            <div class="space-y-2">
                <span class="text-sm font-semibold tracking-wider block">Event Dates <span class="font-normal text-brand-black/50">(optional)</span></span>
                <div class="grid grid-cols-2 lg:grid-cols-1 gap-3">
                    <div>
                        <label for="event_start_date" class="text-xs text-brand-black/60">From</label>
                        <input type="date" id="event_start_date" name="event_start_date"
                            value="{{ old('event_start_date', $a?->event_start_date?->format('Y-m-d')) }}" class="cms-input">
                    </div>
                    <div>
                        <label for="event_end_date" class="text-xs text-brand-black/60">To</label>
                        <input type="date" id="event_end_date" name="event_end_date"
                            value="{{ old('event_end_date', $a?->event_end_date?->format('Y-m-d')) }}" class="cms-input">
                    </div>
                </div>
                <p class="text-xs text-brand-black/50">For posts about something that happened over a day or several — shown as e.g. "12–14 Sep 2026". Leave "To" empty for a single day.</p>
                @error('event_end_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>
        </section>
    </div>
</div>

<div class="mt-6 flex flex-wrap items-center gap-3 justify-end">
    @if ($a && $a->status === 'published')
        <a href="{{ route('updates.show', $a->id) }}" target="_blank" rel="noopener" class="mr-auto text-sm font-semibold text-brand-black/60 hover:text-brand-black underline underline-offset-4">View on site ↗</a>
    @endif
    <a href="{{ route('cms.announcements.index') }}" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">{{ $a ? 'Save Changes' : 'Create Update' }}</button>
</div>
