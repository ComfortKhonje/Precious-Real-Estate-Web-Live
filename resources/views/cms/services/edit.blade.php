@extends('layouts.cms')

@section('title', 'Edit Service | PREC CMS')
@section('page_title', 'Edit Service')
@section('page_subtitle', 'Update content with simple formatting.')

@section('content')
    <div class="bg-white border border-gray-100 rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="font-heading text-3xl leading-none">{{ $serviceTitle }}</h3>
                <p class="text-sm text-brand-black/60 mt-1">Basic editor (frontend stub). Keep formatting simple.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="px-5 py-3 rounded-full bg-gray-100 font-semibold hover:bg-gray-200 transition">Save Draft</button>
                <button type="button" class="px-5 py-3 rounded-full bg-brand-black text-white font-semibold hover:opacity-90 transition">Publish</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Service Title</label>
                    <input type="text" value="{{ $serviceTitle }}" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Short Description</label>
                    <textarea rows="3" placeholder="Short summary..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Description</label>
                    <textarea rows="7" placeholder="Full service description..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Key Service Points</label>
                    <textarea rows="5" placeholder="- Point one\n- Point two\n- Point three" class="w-full bg-gray-100 rounded-2xl py-4 px-5 font-mono text-sm focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Visibility</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option>Visible</option>
                        <option>Hidden</option>
                    </select>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Banner Image</h4>
                    <p class="text-sm text-brand-black/60 mb-5">Upload UI placeholder (backend later).</p>
                    <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-white">
                        <p class="font-semibold">Drop banner image here</p>
                        <p class="text-sm text-brand-black/60 mt-1">Recommended: 1600x600</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                    <h4 class="font-heading text-3xl leading-none mb-2">Live Preview (Optional)</h4>
                    <p class="text-sm text-brand-black/60 mb-5">Preview region placeholder.</p>
                    <div class="rounded-3xl border border-dashed border-gray-200 p-10 text-center bg-white">
                        <p class="text-sm text-brand-black/60">Preview will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

