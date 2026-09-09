@extends('layouts.cms')

@section('title', 'Services Content | PREC CMS')
@section('page_title', 'Services Content')
@section('page_subtitle', 'Edit website service descriptions, visibility, and image assets.')

@section('content')
{{-- Result now shows as a global toast (bottom-right) — see
     x-shared.toast-container in the CMS layout, which reads session('status')
     automatically on every page load. --}}

<x-cms.list-toolbar :create-route="route('cms.services.create')" create-label="Add Service" />

@if ($services->count())
    <p class="text-xs text-brand-black/50 mb-4">{{ $services->count() }} service{{ $services->count() === 1 ? '' : 's' }}</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($services as $service)
            @php $bannerUrl = $service->bannerImageUrl('medium'); @endphp
            <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-lg transition">
                <x-cms.media-thumb :src="$bannerUrl" :alt="$service->title" icon="briefcase">
                    <x-slot:fallback>
                        <div class="w-full h-full flex items-center justify-center bg-brand-black">
                            @if($service->serviceIcon)
                                <img loading="lazy" decoding="async" src="{{ $service->serviceIcon->yellowUrl() }}" alt="" class="w-12 h-12 object-contain">
                            @else
                                <i data-lucide="briefcase" class="w-10 h-10 text-white/30"></i>
                            @endif
                        </div>
                    </x-slot:fallback>

                    @if($bannerUrl && $service->serviceIcon)
                        <div class="absolute top-3 left-3 w-9 h-9 rounded-lg bg-brand-black flex items-center justify-center shadow-sm">
                            <img loading="lazy" decoding="async" src="{{ $service->serviceIcon->yellowUrl() }}" alt="" class="w-4 h-4 object-contain">
                        </div>
                    @endif

                    <x-cms.card-hover-actions
                        :edit-route="route('cms.services.edit', ['slug' => str($service->title)->slug()])"
                        delete-form-id="delete-service-form-{{ $service->id }}"
                        delete-message="Delete this service? This cannot be undone." />
                </x-cms.media-thumb>

                <form id="delete-service-form-{{ $service->id }}" method="POST" action="{{ route('cms.services.destroy', $service) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="p-4">
                    <h3 class="font-heading text-lg font-semibold text-brand-black truncate">{{ $service->title }}</h3>
                    @if($service->tagline)
                        <p class="text-sm text-yellow-600 font-semibold mt-1 truncate">{{ $service->tagline }}</p>
                    @endif
                    <p class="text-xs text-brand-black/60 mt-2 line-clamp-2">{{ $service->short_description ?: 'No description' }}</p>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                        <x-cms.status-pill :active="$service->visible" />
                    </div>

                    <a href="{{ route('cms.services.edit', ['slug' => str($service->title)->slug()]) }}"
                        class="mt-3 block w-full text-center px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold transition flex items-center justify-center gap-1">
                        Edit Service <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <x-cms.empty-state
        icon="briefcase"
        title="No services yet"
        description="Add your first service to showcase what PREC offers."
        :action-route="route('cms.services.create')"
        action-label="Add Service" />
@endif
@endsection
