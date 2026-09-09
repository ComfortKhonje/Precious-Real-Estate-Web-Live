@extends('layouts.cms')

@section('title', 'Add Announcement | PREC CMS')
@section('page_title', 'Add Announcement')
@section('page_subtitle', 'Draft, publish, or archive announcements.')

@section('content')
    <form method="POST" action="{{ route('cms.announcements.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Announcement Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Keep content clear and concise for non-technical users.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        placeholder="Announcement title"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Category</label>
                    <select name="category" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">No category</option>
                        @foreach(\App\Models\Announcement::CATEGORIES as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Posted By (Optional)</label>
                    <select name="team_member_id" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">No byline</option>
                        @foreach ($teamMembers as $member)
                            <option value="{{ $member->id }}" {{ (string) old('team_member_id') === (string) $member->id ? 'selected' : '' }}>{{ $member->name }} — {{ $member->role }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-brand-black/50 mt-1">Shown as "Posted by" on Blog posts.</p>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Short Summary</label>
                    <textarea name="summary" rows="3" placeholder="Short summary..."
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">{{ old('summary') }}</textarea>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Full Content</label>
                    <div data-quill-editor="content">
                        <textarea name="content" rows="8" placeholder="Full content...">{{ old('content') }}</textarea>
                    </div>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Publish Status</label>
                    <select name="status" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Featured</label>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-brand-black focus:ring-primary">
                        <span class="text-sm text-brand-black/70">Mark as featured</span>
                    </div>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Publish At</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                        class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <x-cms.image-upload name="cover_image" label="Select Cover Image" :required="true" help="Every post needs at least one image" />
                </div>
                <div class="space-y-2 md:col-span-2">
                    <x-cms.image-upload name="gallery[]" label="Upload Additional Gallery Images" :multiple="true" />
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <a href="{{ route('cms.announcements.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Announcement</button>
        </div>
    </form>
@endsection

@push('scripts')
    @vite('resources/js/cms-editor.js')
@endpush
