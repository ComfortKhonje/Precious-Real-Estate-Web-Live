@extends('layouts.cms')

@section('title', 'Contact Information | PREC CMS')
@section('page_title', 'Contact Information')
@section('page_subtitle', 'Update office details, contacts, social links, and map settings.')

@section('content')
    <form class="space-y-6">
        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Office Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Supports multiple office locations later (backend wiring).</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Name</label>
                    <input type="text" placeholder="Precious Real Estate Consulting" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Working Hours</label>
                    <input type="text" placeholder="Mon-Fri, 08:00-17:00" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Physical Address</label>
                    <input type="text" placeholder="Enter physical address" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">Postal Address</label>
                    <input type="text" placeholder="Enter postal address" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Contact Details</h3>
            <p class="text-sm text-brand-black/60 mb-6">Phone numbers, email addresses, WhatsApp.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Phone Numbers</label>
                    <input type="text" placeholder="+265 ..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Email Addresses</label>
                    <input type="text" placeholder="info@..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-semibold tracking-wider">WhatsApp Number</label>
                    <input type="text" placeholder="+265 ..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Social Media Links</h3>
            <p class="text-sm text-brand-black/60 mb-6">Facebook, WhatsApp, YouTube, TikTok.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2"><label class="text-sm font-semibold tracking-wider">Facebook</label><input type="text" placeholder="https://facebook.com/..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></div>
                <div class="space-y-2"><label class="text-sm font-semibold tracking-wider">WhatsApp</label><input type="text" placeholder="https://wa.me/..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></div>
                <div class="space-y-2"><label class="text-sm font-semibold tracking-wider">YouTube</label><input type="text" placeholder="https://youtube.com/..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></div>
                <div class="space-y-2"><label class="text-sm font-semibold tracking-wider">TikTok</label><input type="text" placeholder="https://tiktok.com/@..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20"></div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-3xl p-6">
            <h3 class="font-heading text-3xl leading-none mb-1">Embedded Map Settings</h3>
            <p class="text-sm text-brand-black/60 mb-6">Google maps link and coordinates.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Google Maps Link</label>
                    <input type="text" placeholder="https://maps.google.com/..." class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Office Coordinates</label>
                    <input type="text" placeholder="-13.9, 33.7" class="w-full bg-gray-100 rounded-2xl py-4 px-5 focus:ring-2 focus:ring-primary focus:bg-white border border-transparent focus:border-primary/20">
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="button" class="btn-primary">Save Changes</button>
        </div>
    </form>
@endsection

