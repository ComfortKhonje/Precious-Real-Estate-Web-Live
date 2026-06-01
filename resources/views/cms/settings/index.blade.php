@extends('layouts.cms')

@section('title', 'Settings | PREC CMS')
@section('page_title', 'Settings')
@section('page_subtitle', 'Basic administration and website preferences.')

@section('content')
    <form class="space-y-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">General Settings</h3>
            <p class="text-sm text-brand-black/60 mb-6">Keep settings minimal and organized.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Website Name</label>
                    <input type="text" placeholder="Precious Real Estate Consulting" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">System Email</label>
                    <input type="email" placeholder="admin@preciousrealestate.mw" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Time Zone</label>
                    <input type="text" placeholder="Africa/Blantyre" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Website Logo</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gray-50">
                        <p class="text-sm text-brand-black/60">Upload UI placeholder.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Website Preferences</h3>
            <p class="text-sm text-brand-black/60 mb-6">Featured limits, inquiry email destination, default statuses.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Homepage featured property limit</label>
                    <input type="number" min="0" placeholder="6" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Inquiry email destination</label>
                    <input type="email" placeholder="info@preciousrealestate.mw" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Default property status</label>
                    <select class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20 cursor-pointer">
                        <option>Available</option>
                        <option>Sold</option>
                        <option>Rented</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Password Management</h3>
            <p class="text-sm text-brand-black/60 mb-6">Sensitive actions should require confirmation (backend later).</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Current Password</label>
                    <input type="password" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">New Password</label>
                    <input type="password" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Confirm Password</label>
                    <input type="password" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="button" class="btn-primary">Save Settings</button>
        </div>
    </form>
@endsection

