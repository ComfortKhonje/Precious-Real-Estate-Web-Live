@extends('layouts.cms')

@section('title', 'Services Content | PREC CMS')
@section('page_title', 'Services Content')
@section('page_subtitle', 'Edit website service descriptions, visibility, and image assets.')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-heading text-3xl leading-none">Services</h3>
                    <span class="text-xs text-brand-black/50">{{ $services->count() }} items</span>
                </div>
                <a href="{{ route('cms.services.create') }}" class="btn-primary inline-flex items-center px-4 py-3">
                    Add Service
                </a>
            </div>
            <div class="p-3 space-y-2">
                @forelse ($services as $service)
                    <div class="rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden">
                        <div class="px-4 py-4 flex items-center justify-between gap-3 hover:bg-gray-100 transition">
                            <div>
                                <div class="font-semibold">{{ $service->title }}</div>
                                <div class="text-xs text-brand-black/50 mt-1">Last updated:
                                    {{ $service->updated_at->diffForHumans() }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full {{ $service->visible ? 'bg-primary/40 text-brand-black' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $service->visible ? 'Visible' : 'Hidden' }}
                                </span>
                                <a href="{{ route('cms.services.edit', ['slug' => str($service->title)->slug()]) }}"
                                    class="btn-secondary">Edit</a>
                                <form action="{{ route('cms.services.destroy', $service) }}" method="POST"
                                    onsubmit="return confirm('Delete this service? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-10 text-center text-sm text-brand-black/60">
                        No services are configured yet. Use the button above to create the first service.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Service Editor</h3>
            <p class="text-sm text-brand-black/60 mb-6">Select a service to edit or create a new one. You can also delete a service directly from the list.</p>

            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <p class="font-semibold">Open a service detail panel</p>
                <p class="text-sm text-brand-black/60 mt-1">Ready to update short descriptions, full content and visibility.</p>
            </div>
        </div>
    </div>
@endsection
