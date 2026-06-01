@extends('layouts.cms')

@section('title', 'Add Announcement | PREC CMS')
@section('page_title', 'Add Announcement')
@section('page_subtitle', 'Draft, publish, or archive announcements.')

@section('content')
    <form class="space-y-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Announcement Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Keep content clear and concise for non-technical users.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Title</label>
                    <input type="text" placeholder="Announcement title" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Short Summary</label>
                    <textarea rows="3" placeholder="Short summary..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Full Content</label>
                    <textarea rows="8" placeholder="Full content..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Publish Status</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option>Draft</option>
                        <option>Published</option>
                        <option>Archived</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Featured</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option>No</option>
                        <option>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Cover Image</h3>
            <p class="text-sm text-brand-black/60 mb-6">Upload UI placeholder (backend later).</p>
            <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <p class="font-semibold">Drop cover image here</p>
                <p class="text-sm text-brand-black/60 mt-1">Recommended: 1600x900</p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <a href="{{ route('cms.announcements.index') }}" class="btn-secondary">Cancel</a>
            <button type="button" class="btn-primary">Save</button>
        </div>
    </form>
@endsection

