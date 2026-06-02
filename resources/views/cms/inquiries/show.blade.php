@extends('layouts.cms')

@section('title', 'Inquiry Details | PREC CMS')
@section('page_title', 'Inquiry Details')
@section('page_subtitle', 'Review and manage the selected inquiry.')

@section('content')
    <div class="grid grid-cols-1 xl:grid-cols-[350px_1fr] gap-6">
        <div class="space-y-6">
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <h3 class="font-heading text-3xl leading-none mb-3">{{ $inquiry->name }}</h3>
                <p class="text-sm text-brand-black/70 mb-3">Submitted on
                    {{ $inquiry->created_at->format('M j, Y \a\t g:i A') }}</p>
                <div class="space-y-3 text-sm text-brand-black/80">
                    <div><span class="font-semibold">Type:</span> {{ ucfirst($inquiry->type) }}</div>
                    <div><span class="font-semibold">Email:</span> <a href="mailto:{{ $inquiry->email }}"
                            class="text-primary">{{ $inquiry->email }}</a></div>
                    <div><span class="font-semibold">Phone:</span> {{ $inquiry->phone ?? '—' }}</div>
                    @if ($inquiry->property_id)
                        <div><span class="font-semibold">Property:</span>
                            {{ optional($inquiry->property)->title ?? 'Unknown property' }}</div>
                    @endif
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <h4 class="font-semibold text-lg mb-3">Message</h4>
                <p class="whitespace-pre-line text-brand-black/80">{{ $inquiry->message }}</p>
            </div>

            <form method="POST" action="{{ route('cms.inquiries.destroy', $inquiry) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete Inquiry</button>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h4 class="font-semibold text-lg mb-3">Actions</h4>
            <div class="space-y-3 text-sm text-brand-black/80">
                <a href="{{ route('cms.inquiries.index') }}" class="block text-primary">Back to inquiries</a>
                <p>You can delete an inquiry if it has been handled.</p>
            </div>
        </div>
    </div>
@endsection
