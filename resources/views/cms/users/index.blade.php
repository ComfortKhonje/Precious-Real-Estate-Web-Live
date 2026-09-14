@extends('layouts.cms')

@section('title', 'Staff Accounts | PREC CMS')
@section('page_title', 'Staff Accounts')
@section('page_subtitle', 'Who can log in to the CMS, and what each person can change.')

@section('content')
    @if(session('generated_password'))
        {{-- Shown once, right after creating an account without typing a
             password. Never stored anywhere in plain text. --}}
        <div class="mb-6 p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900">
            <div class="font-semibold mb-1">Generated password — copy it now, it won't be shown again:</div>
            <code class="inline-block mt-1 px-3 py-2 rounded-xl bg-white border border-amber-200 font-mono text-base select-all">{{ session('generated_password') }}</code>
            <p class="text-sm mt-2">Give it to the person privately (not by email). They'll be asked to change it on first login if you left that option on.</p>
        </div>
    @endif

    <x-cms.list-toolbar
        :search-route="route('cms.users.index')"
        :search-value="request('search')"
        search-placeholder="Search by name or email..."
        :create-route="route('cms.users.create')"
        create-label="Add Account" />

    @if ($users->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach ($users as $account)
                @php $manageable = auth()->user()->canManage($account); @endphp
                <div class="bg-white border border-gray-100 rounded-3xl p-5 flex flex-col hover:shadow-lg transition">
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 shrink-0 rounded-2xl bg-primary/20 text-brand-black flex items-center justify-center font-heading text-xl">
                            {{ strtoupper(mb_substr($account->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-heading text-lg font-semibold text-brand-black truncate">
                                {{ $account->name }}
                                @if($account->is(auth()->user())) <span class="text-xs font-body text-brand-black/50">(you)</span> @endif
                            </h3>
                            <p class="text-sm text-brand-black/60 truncate">{{ $account->email }}</p>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            {{ $account->isSuperAdmin() ? 'bg-brand-black text-white' : ($account->role === 'admin' ? 'bg-primary/30 text-brand-black' : 'bg-gray-100 text-brand-black/70') }}">
                            {{ $account->roleLabel() }}
                        </span>
                        @if($account->must_change_password)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Password change pending</span>
                        @endif
                    </div>

                    <div class="mt-auto pt-4 flex gap-2">
                        @if($manageable)
                            <a href="{{ route('cms.users.edit', $account) }}"
                                class="flex-1 text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                                Edit <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                            @unless($account->is(auth()->user()))
                                <form id="delete-user-form-{{ $account->id }}" method="POST" action="{{ route('cms.users.destroy', $account) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" aria-label="Remove {{ $account->name }}"
                                    class="px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 transition"
                                    @click="confirmFormId = 'delete-user-form-{{ $account->id }}'; confirmTitle = 'Remove Account'; confirmMessage = 'Remove {{ addslashes($account->name) }}? They will no longer be able to log in.'; confirmActionLabel = 'Yes, Remove'; confirmLoadingLabel = 'Removing&hellip;'; confirmModalOpen = true">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            @endunless
                        @else
                            <p class="text-xs text-brand-black/50">Only a Super Admin can change this account.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    @else
        <x-cms.empty-state
            icon="search-x"
            title="No matching accounts"
            description="Try a different search term or clear the search above."
            :action-route="route('cms.users.index')"
            action-label="Clear Search"
            action-icon="x" />
    @endif

    <div class="mt-8 cms-panel p-6">
        <h3 class="cms-section-title mb-3">What each role can do</h3>
        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            @foreach(\App\Models\User::ROLE_LABELS as $role => $label)
                <div>
                    <dt class="font-semibold">{{ $label }}</dt>
                    <dd class="text-brand-black/60 mt-1">{{ \App\Models\User::ROLE_DESCRIPTIONS[$role] }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
@endsection
