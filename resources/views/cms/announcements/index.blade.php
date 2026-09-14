@extends('layouts.cms')

@section('title', 'Announcements & News | PREC CMS')
@section('page_title', 'Announcements & News')
@section('page_subtitle', 'Publish updates, notices, and company announcements.')

@section('content')
<x-cms.list-toolbar
    :search-route="route('cms.announcements.index')"
    :search-value="request('search')"
    search-placeholder="Search announcements..."
    :clear-route="request()->anyFilled(['search', 'status']) ? route('cms.announcements.index') : null"
    :create-route="route('cms.announcements.create')"
    create-label="Add Announcement">
    <x-slot:filters>
        <select name="status" onchange="this.form.submit()" class="cms-select bg-white border-gray-200 py-3 px-4 text-sm w-auto min-w-[9rem] max-w-[11rem] truncate">
            <option value="">All Status</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
    </x-slot:filters>
</x-cms.list-toolbar>

@if ($announcements->isEmpty() && request()->anyFilled(['search', 'status']))
    <x-cms.empty-state
        icon="search-x"
        title="No matching announcements"
        description="Try a different search term or clear the filters above."
        :action-route="route('cms.announcements.index')"
        action-label="Clear Filters"
        action-icon="x" />
@elseif ($announcements->isEmpty())
    <x-cms.empty-state
        icon="megaphone"
        title="No announcements found"
        description="Create your first announcement to share important updates with clients."
        :action-route="route('cms.announcements.create')"
        action-label="Create Announcement" />
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($announcements as $announcement)
            <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <x-cms.media-thumb :src="$announcement->coverImageUrl('medium')" :alt="$announcement->title" icon="newspaper">
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm bg-white/90 text-brand-black">
                            {{ $announcement->category ?? 'Announcement' }}
                        </span>
                        @if($announcement->is_featured)
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm bg-brand-black text-primary flex items-center gap-1">
                                <i data-lucide="star" class="w-3 h-3"></i> Featured
                            </span>
                        @endif
                    </div>
                    <x-cms.card-hover-actions
                        :edit-route="route('cms.announcements.edit', $announcement)"
                        delete-form-id="delete-announcement-form-{{ $announcement->id }}"
                        delete-message="Delete this announcement?" />
                </x-cms.media-thumb>

                <form id="delete-announcement-form-{{ $announcement->id }}" method="POST" action="{{ route('cms.announcements.destroy', $announcement) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="p-4">
                    <h3 class="font-heading text-lg font-semibold text-brand-black truncate">{{ $announcement->title }}</h3>
                    <p class="text-sm text-yellow-600 font-semibold mt-1">
                        {{ $announcement->published_at ? $announcement->published_at->format('M j, Y') : 'Not yet published' }}
                    </p>
                    <p class="text-xs text-brand-black/60 mt-2 line-clamp-2">{{ $announcement->summary ?: 'No summary' }}</p>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                            {{ $announcement->status === 'published' ? 'bg-emerald-100 text-emerald-700' : ($announcement->status === 'archived' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($announcement->status) }}
                        </span>
                    </div>

                    <a href="{{ route('cms.announcements.edit', $announcement) }}"
                        class="mt-3 block w-full text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                        Edit Announcement <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $announcements->withQueryString()->links() }}
    </div>
@endif
@endsection
