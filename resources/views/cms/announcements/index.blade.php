@extends('layouts.cms')

@section('title', 'Announcements & News | PREC CMS')
@section('page_title', 'Announcements & News')
@section('page_subtitle', 'Publish updates, notices, and company announcements.')

@section('content')
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('cms.announcements.index') }}" class="flex-1">
            <div class="relative">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search announcements..."
                    class="w-full bg-white border border-gray-200 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                <svg class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
            </div>
        </form>
        <div class="flex gap-2 items-center">
            <form method="GET" action="{{ route('cms.announcements.index') }}" class="inline-flex">
                <select name="status" onchange="this.form.submit()"
                    class="bg-white border border-gray-200 rounded-2xl py-3 px-4 text-sm font-semibold focus:ring-2 focus:ring-primary focus:border-primary/30 cursor-pointer">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </form>
            <a href="{{ route('cms.announcements.create') }}" class="btn-primary">Add Announcement</a>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold text-brand-black/70">Announcements</p>
                <p class="text-xs text-brand-black/50">{{ $announcements->total() }}
                    item{{ $announcements->total() === 1 ? '' : 's' }}</p>
            </div>
            <a href="{{ route('cms.announcements.create') }}" class="text-sm font-semibold text-primary">Create new
                announcement</a>
        </div>

        @if ($announcements->isEmpty())
            <div class="p-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <h3 class="font-heading text-3xl leading-none mb-2">No announcements found</h3>
                <p class="text-brand-black/60 max-w-xl mx-auto">Create your first announcement to share important updates
                    with clients.</p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('cms.announcements.create') }}" class="btn-primary">Create Announcement</a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-brand-black/70">
                        <tr>
                            <th class="px-6 py-4">Title</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Published</th>
                            <th class="px-6 py-4">Featured</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $announcement->title }}</div>
                                    <div class="text-xs text-brand-black/50">
                                        {{ \Illuminate\Support\Str::limit($announcement->summary, 70) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $announcement->status === 'published' ? 'bg-emerald-100 text-emerald-700' : ($announcement->status === 'archived' ? 'bg-gray-100 text-gray-700' : 'bg-yellow-100 text-yellow-700') }}">{{ ucfirst($announcement->status) }}</span>
                                </td>
                                <td class="px-6 py-4">{{ optional($announcement->published_at)->format('M j, Y') }}</td>
                                <td class="px-6 py-4">{{ $announcement->is_featured ? 'Yes' : 'No' }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('cms.announcements.edit', $announcement) }}"
                                        class="text-primary font-semibold">Edit</a>
                                    <form method="POST" action="{{ route('cms.announcements.destroy', $announcement) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Delete this announcement?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50">
                {{ $announcements->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
