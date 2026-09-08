@extends('layouts.cms')

@section('title', 'Team Members | PREC CMS')
@section('page_title', 'Team Members')
@section('page_subtitle', 'Manage your team members and staff directory.')

@section('content')
    {{-- Result now shows as a global toast (bottom-right) — see
         x-shared.toast-container in the CMS layout. --}}

    <div class="mb-6 flex items-center justify-between gap-4">
        <form method="GET" action="{{ route('cms.team-members.index') }}" class="flex gap-3 flex-1">
            <input type="text" name="search" placeholder="Search by name or role..." value="{{ request('search') }}"
                class="flex-1 bg-white border border-gray-200 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-primary focus:border-primary transition">
            <button type="submit" class="px-6 py-3 rounded-full bg-white border border-gray-200 font-semibold hover:bg-gray-50 transition">
                <i data-lucide="search" class="w-4 h-4 inline mr-1"></i> Search
            </button>
        </form>
        <a href="{{ route('cms.team-members.create') }}"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition whitespace-nowrap">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Member
        </a>
    </div>

    @if ($teamMembers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($teamMembers as $member)
                <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                    <!-- Photo -->
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if ($member->photo_url)
                            <img loading="lazy" decoding="async" src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset('storage/' . $member->photo_url . '/medium.webp') }}" alt="{{ $member->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-primary/10">
                                <i data-lucide="user" class="w-16 h-16 text-brand-black/40"></i>
                            </div>
                        @endif
                        <!-- Overlay with actions -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            <a href="{{ route('cms.team-members.edit', $member) }}"
                                class="p-2 rounded-full bg-primary text-brand-black hover:bg-primary/90 transition flex items-center justify-center" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form id="delete-member-form-{{ $member->id }}" method="POST" action="{{ route('cms.team-members.destroy', $member) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                    @click="confirmFormId = 'delete-member-form-{{ $member->id }}'; confirmMessage = 'Remove {{ addslashes($member->name) }} from team?'; confirmModalOpen = true"
                                    class="p-2 rounded-full bg-red-500 text-white hover:bg-red-600 transition flex items-center justify-center" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Member Info -->
                    <div class="p-4">
                        <h3 class="font-heading text-lg font-semibold text-brand-black">{{ $member->name }}</h3>
                        <p class="text-sm text-yellow-600 font-semibold mt-1">{{ $member->role }}</p>
                        <p class="text-xs text-brand-black/60 mt-2 line-clamp-2">{{ $member->bio ?? 'No bio' }}</p>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                {{ $member->visible ? 'bg-primary/10 border-2 border-primary/30 text-yellow-800' : 'bg-gray-100 text-gray-600' }}">
                                @if ($member->visible)
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i> Visible
                                @else
                                    <i data-lucide="eye-off" class="w-3.5 h-3.5"></i> Hidden
                                @endif
                            </span>
                            <span class="text-xs text-brand-black/50">#{{ $member->order }}</span>
                        </div>

                        <a href="{{ route('cms.team-members.edit', $member) }}"
                            class="mt-3 block w-full text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                            View Details <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $teamMembers->links() }}
        </div>
    @else
        <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-primary/20 flex items-center justify-center text-4xl mb-4 text-primary">
                <i data-lucide="users" class="w-10 h-10"></i>
            </div>
            <h3 class="font-heading text-2xl font-semibold text-brand-black mb-2">No team members yet</h3>
            <p class="text-brand-black/60 mb-6">Add your first team member to get started.</p>
            <a href="{{ route('cms.team-members.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add First Member
            </a>
        </div>
    @endif
@endsection
