@extends('layouts.cms')

@section('title', 'Announcements & News | PREC CMS')
@section('page_title', 'Announcements & News')
@section('page_subtitle', 'Publish updates, notices, and company announcements.')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex-1">
            <div class="relative">
                <input type="text" placeholder="Search announcements..." class="w-full bg-white border border-gray-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                <svg class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"/>
                </svg>
            </div>
        </div>
        <div class="flex gap-2">
            <select class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30">
                <option>All Status</option>
                <option>Draft</option>
                <option>Published</option>
                <option>Archived</option>
            </select>
            <a href="{{ route('cms.announcements.create') }}" class="btn-primary">Add Announcement</a>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm font-semibold text-brand-black/70">Announcements</p>
            <p class="text-xs text-brand-black/50">0 items</p>
        </div>

        <div class="p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
            <h3 class="font-heading text-3xl leading-none mb-2">No announcements yet</h3>
            <p class="text-brand-black/60 max-w-xl mx-auto">Create your first announcement to share important updates with clients.</p>
            <div class="mt-6 flex justify-center">
                <a href="{{ route('cms.announcements.create') }}" class="btn-primary">Create Announcement</a>
            </div>
        </div>
    </div>
@endsection

