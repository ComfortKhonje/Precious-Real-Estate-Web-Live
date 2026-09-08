@extends('layouts.cms')

@section('title', 'Services Content | PREC CMS')
@section('page_title', 'Services Content')
@section('page_subtitle', 'Edit website service descriptions, visibility, and image assets.')

@section('content')
@if (session('status'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-3xl p-6">
    <h3 class="font-semibold text-green-900 flex items-center gap-2"><i data-lucide="check" class="w-5 h-5"></i> {{ session('status') }}</h3>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-heading text-3xl leading-none">Services</h3>
            <span class="text-xs text-brand-black/50">{{ $services->count() }} total</span>
        </div>

        <div class="p-3 space-y-2 max-h-[600px] overflow-y-auto">
            @foreach ($services as $service)
            <div class="group px-4 py-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition border border-gray-100">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <a href="{{ route('cms.services.edit', ['slug' => str($service->title)->slug()]) }}"
                        class="flex-1 flex items-center gap-3 font-semibold text-brand-black hover:text-primary transition">
                        <span class="w-8 h-8 rounded-lg bg-brand-black flex items-center justify-center shrink-0">
                            @if ($service->serviceIcon)
                                <img loading="lazy" decoding="async" src="{{ $service->serviceIcon->yellowUrl() }}" alt="" class="w-4 h-4 object-contain">
                            @else
                                <i data-lucide="image" class="w-4 h-4 text-white/40"></i>
                            @endif
                        </span>
                        {{ $service->title }}
                    </a>
                    <form id="delete-service-form-{{ $service->id }}" method="POST" action="{{ route('cms.services.destroy', $service) }}"
                        class="opacity-0 group-hover:opacity-100 transition">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            @click="confirmFormId = 'delete-service-form-{{ $service->id }}'; confirmMessage = 'Delete this service? This cannot be undone.'; confirmModalOpen = true"
                            class="p-1.5 text-red-600 hover:bg-red-50 rounded transition flex items-center justify-center"
                            title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>

                <div class="flex items-center justify-between gap-2">
                    <p class="text-xs text-brand-black/50 line-clamp-1">
                        {{ $service->short_description ?: 'No description' }}
                    </p>
                    <span
                        class="text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full whitespace-nowrap {{ $service->visible ? 'bg-primary/40 text-brand-black' : 'bg-gray-200 text-gray-600' }}">
                        {{ $service->visible ? 'Visible' : 'Hidden' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            <a href="{{ route('cms.services.create') }}"
                class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-full bg-primary text-brand-black font-semibold hover:bg-primary/90 transition text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Service
            </a>
        </div>
    </div>

    <!-- Editor Panel -->
    <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
        <h3 class="font-heading text-3xl leading-none mb-2">Service Editor</h3>
        <p class="text-sm text-brand-black/60 mb-6">Select a service to edit or create a new one. You can also delete a service directly from the list.</p>

        <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
            <div
                class="w-16 h-16 mx-auto rounded-3xl bg-primary/20 border border-primary/30 mb-4 flex items-center justify-center text-primary">
                <i data-lucide="file-text" class="w-8 h-8"></i>
            </div>
            <p class="font-semibold">Open a service to edit</p>
            <p class="text-sm text-brand-black/60 mt-1">Select a service from the left to update its content and
                visibility.</p>
            <p class="text-sm text-brand-black/60 mt-4">Or <a href="{{ route('cms.services.create') }}"
                    class="text-primary font-semibold hover:underline">create a new service</a></p>
        </div>
    </div>
</div>
@endsection