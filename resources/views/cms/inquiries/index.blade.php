@extends('layouts.cms')

@section('title', 'Inquiries | PREC CMS')
@section('page_title', 'Inquiries')
@section('page_subtitle', 'Central inbox for website and service inquiries.')

@section('content')
    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center gap-3">
            <div class="flex-1">
                <div class="relative">
                    <input type="search" name="search" form="inquiryFilters" value="{{ request('search') }}"
                        placeholder="Search by name, email, property, service..."
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary focus:border-primary/30">
                    <i data-lucide="search" class="w-5 h-5 text-brand-black/40 absolute left-4 top-1/2 -translate-y-1/2"></i>
                </div>
            </div>
            <form id="inquiryFilters" method="GET" action="{{ route('cms.inquiries.index') }}" class="flex flex-wrap gap-2 items-center">
                <select name="type" onchange="this.form.submit()" class="cms-select bg-gray-50 border-gray-100 py-3 px-4 text-sm w-auto min-w-[9rem] max-w-[11rem] truncate">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @if(request()->anyFilled(['search', 'type']))
                    <a href="{{ route('cms.inquiries.index') }}" class="p-3 rounded-2xl bg-gray-100 text-brand-black/60 hover:bg-gray-200 transition" title="Clear Filters">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </a>
                @endif
            </form>
            @if($newCount > 0)
                <span class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-primary/20 text-brand-black text-sm font-bold whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    {{ $newCount }} new
                </span>
            @endif
        </div>

        @if ($inquiries->isEmpty())
            <div class="p-8">
                <x-cms.empty-state
                    icon="inbox"
                    title="No inquiries found"
                    description="When users submit inquiries on the website, they'll appear here." />
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($inquiries as $inquiry)
                    <a href="{{ route('cms.inquiries.show', $inquiry) }}" class="flex items-center justify-between gap-4 px-6 py-5 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4 min-w-0">
                            <span class="w-2 h-2 rounded-full shrink-0 {{ $inquiry->is_new ? 'bg-primary' : 'bg-transparent' }}" title="{{ $inquiry->is_new ? 'New' : '' }}"></span>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-brand-black">{{ $inquiry->name }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-gray-100 text-brand-black/70 text-xs font-semibold whitespace-nowrap">{{ $inquiry->type ?? 'General' }}</span>
                                </div>
                                <div class="text-sm text-brand-black/60 truncate">{{ $inquiry->email }}</div>
                                @if($inquiry->property_id)
                                    <div class="text-xs text-primary font-semibold mt-0.5 truncate">Re: {{ optional($inquiry->property)->title ?? 'Deleted property' }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-sm text-brand-black/50 whitespace-nowrap shrink-0">{{ $inquiry->created_at->diffForHumans() }}</div>
                    </a>
                @endforeach
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
@endsection
