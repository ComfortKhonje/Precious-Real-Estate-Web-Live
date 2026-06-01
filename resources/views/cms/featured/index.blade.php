@extends('layouts.cms')

@section('title', 'Featured Properties | PREC CMS')
@section('page_title', 'Featured Properties')
@section('page_subtitle', 'Manage which listings appear as featured.')

@section('content')
    <div class="bg-white border border-gray-100 rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-heading text-3xl leading-none">Featured List</h3>
                <p class="text-sm text-brand-black/60 mt-1">Drag and drop ordering (frontend stub).</p>
            </div>
            <a href="{{ route('cms.properties.index') }}" class="btn-secondary">Open Listings</a>
        </div>

        <div class="border border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
            <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
            <h4 class="font-heading text-3xl leading-none mb-2">No featured properties</h4>
            <p class="text-brand-black/60 max-w-xl mx-auto">Once you mark properties as featured, they will appear here and you can reorder them.</p>
        </div>
    </div>
@endsection

