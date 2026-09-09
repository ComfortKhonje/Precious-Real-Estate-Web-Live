@extends('layouts.cms')

@section('title', 'Team Members | PREC CMS')
@section('page_title', 'Team Members')
@section('page_subtitle', 'Manage your team members and staff directory.')

@section('content')
    {{-- Result now shows as a global toast (bottom-right) — see
         x-shared.toast-container in the CMS layout. --}}

    <x-cms.list-toolbar
        :search-route="route('cms.team-members.index')"
        :search-value="request('search')"
        search-placeholder="Search by name or role..."
        :create-route="route('cms.team-members.create')"
        create-label="Add Member" />

    @if ($teamMembers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($teamMembers as $member)
                <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                    {{-- photo_url check first: TeamMember::photoUrl() falls back to the
                         generic "image under construction" house placeholder, which
                         reads fine for a property with no photo but not for a person —
                         media-thumb's own user-icon fallback fits a missing headshot better. --}}
                    <x-cms.media-thumb :src="$member->photo_url ? $member->photoUrl('medium') : null" :alt="$member->name" icon="user">
                        <x-cms.card-hover-actions
                            :edit-route="route('cms.team-members.edit', $member)"
                            delete-form-id="delete-member-form-{{ $member->id }}"
                            delete-message="Remove {{ $member->name }} from team?" />
                    </x-cms.media-thumb>

                    <form id="delete-member-form-{{ $member->id }}" method="POST" action="{{ route('cms.team-members.destroy', $member) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>

                    <!-- Member Info -->
                    <div class="p-4">
                        <h3 class="font-heading text-lg font-semibold text-brand-black truncate">{{ $member->name }}</h3>
                        <p class="text-sm text-yellow-600 font-semibold mt-1 truncate">{{ $member->role }}</p>
                        <p class="text-xs text-brand-black/60 mt-2 line-clamp-2">{{ $member->bio ?? 'No bio' }}</p>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                            <x-cms.status-pill :active="$member->visible" />
                            <span class="text-xs text-brand-black/50">#{{ $member->order }}</span>
                        </div>

                        <a href="{{ route('cms.team-members.edit', $member) }}"
                            class="mt-3 block w-full text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                            Edit Member <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $teamMembers->links() }}
        </div>
    @elseif(request()->filled('search'))
        <x-cms.empty-state
            icon="search-x"
            title="No matching team members"
            description="Try a different search term or clear the search above."
            :action-route="route('cms.team-members.index')"
            action-label="Clear Search"
            action-icon="x" />
    @else
        <x-cms.empty-state
            icon="users"
            title="No team members yet"
            description="Add your first team member to get started."
            :action-route="route('cms.team-members.create')"
            action-label="Add First Member" />
    @endif
@endsection
