@extends('layouts.cms')

@section('title', 'Add Property | PREC CMS')
@section('page_title', 'Add Property')
@section('page_subtitle', 'Create a new listing for the website.')

@section('content')
    <form class="space-y-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Property Information</h3>
            <p class="text-sm text-brand-black/60 mb-6">Basic details shown on the property card and listing page.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Title</label>
                    <input type="text" placeholder="e.g., 3 Bedroom House in Area 10" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Category</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">Select category</option>
                        <option>Residential</option>
                        <option>Commercial</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Property Type</label>
                    <input type="text" placeholder="e.g., House, Apartment, Plot" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Price</label>
                    <input type="text" placeholder="e.g., MWK 120,000,000" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Location</label>
                    <input type="text" placeholder="e.g., Lilongwe, Area 10" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Status</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option>Available</option>
                        <option>Sold</option>
                        <option>Rented</option>
                    </select>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Property Description</label>
                    <textarea rows="5" placeholder="Write a clear description of the property..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></textarea>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Property Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Extra details that help buyers and renters decide faster.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Bedrooms</label>
                    <input type="number" min="0" placeholder="0" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Bathrooms</label>
                    <input type="number" min="0" placeholder="0" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Land Size</label>
                    <input type="text" placeholder="e.g., 500 sqm, 0.25 acre" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Parking Availability</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option value="">Select</option>
                        <option>Yes</option>
                        <option>No</option>
                    </select>
                </div>
                <div class="space-y-2 lg:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Additional Features</label>
                    <input type="text" placeholder="e.g., Solar, Water tank, Electric fence" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Media Uploads</h3>
            <p class="text-sm text-brand-black/60 mb-6">Drag and drop upload UI (frontend stub).</p>

            <div class="border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center bg-gray-50">
                <div class="w-16 h-16 mx-auto rounded-3xl bg-primary/35 border border-primary/50 mb-4"></div>
                <p class="font-semibold">Drop images here</p>
                <p class="text-sm text-brand-black/60 mt-1">or click to browse (backend wiring later).</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Inquiry Settings</h3>
            <p class="text-sm text-brand-black/60 mb-6">Control inquiry availability for this property.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <label class="flex items-center justify-between gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100">
                    <div>
                        <div class="font-semibold">Enable inquiry form</div>
                        <div class="text-sm text-brand-black/60">Allow users to inquire about this listing.</div>
                    </div>
                    <input type="checkbox" class="rounded border-gray-300 text-brand-black focus:ring-primary">
                </label>
                <label class="flex items-center justify-between gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100">
                    <div>
                        <div class="font-semibold">Featured property</div>
                        <div class="text-sm text-brand-black/60">Show this listing in featured sections.</div>
                    </div>
                    <input type="checkbox" class="rounded border-gray-300 text-brand-black focus:ring-primary">
                </label>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <a href="{{ route('cms.properties.index') }}" class="btn-secondary">Cancel</a>
            <button type="button" class="btn-primary">Save Property</button>
        </div>
    </form>
@endsection

