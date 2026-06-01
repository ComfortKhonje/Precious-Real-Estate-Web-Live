@extends('layouts.cms')

@section('title', 'Analytics | PREC CMS')
@section('page_title', 'Analytics')
@section('page_subtitle', 'Simple overview of visits, inquiries, and property engagement.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach(['Total website visits','Property views','Inquiry submissions','Most viewed properties'] as $label)
            <div class="bg-white border border-gray-100 rounded-3xl p-6">
                <p class="text-xs uppercase tracking-[0.2em] text-brand-black/50 mb-2">{{ $label }}</p>
                <div class="flex items-end justify-between">
                    <div class="font-heading text-5xl leading-none">0</div>
                    <div class="w-10 h-10 rounded-2xl bg-primary/40 border border-primary/50"></div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Performance Charts</h3>
            <p class="text-sm text-brand-black/60 mb-6">Weekly visits, monthly inquiries, property engagement (stub).</p>
            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <p class="text-sm text-brand-black/60">Charts will render here once analytics is connected.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-2">Top Performing Properties</h3>
            <p class="text-sm text-brand-black/60 mb-6">Shows the properties with the most engagement.</p>
            <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <p class="text-sm text-brand-black/60">No data yet.</p>
            </div>
        </div>
    </div>
@endsection

