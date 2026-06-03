@extends('layouts.cms')

@section('title', 'Settings | PREC CMS')
@section('page_title', 'Settings')
@section('page_subtitle', 'Operational preferences and access security.')

@section('content')
    <form class="space-y-6">
        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Operational Preferences</h3>
            <p class="text-sm text-brand-black/60 mb-6">Only backend-facing preferences live here. Main website branding stays controlled in the frontend.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">System Email</label>
                    <input type="email" placeholder="admin@preciousrealestate.mw" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Time Zone</label>
                    <input type="text" placeholder="Africa/Blantyre" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Inquiry Email Destination</label>
                    <input type="email" placeholder="info@preciousrealestate.mw" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Default Property Status</label>
                    <x-ui.select class="cms-select">
                        <option>Available</option>
                        <option>Sold</option>
                        <option>Rented</option>
                    </x-ui.select>
                </div>
            </div>
        </div>

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Access & Notifications</h3>
            <p class="text-sm text-brand-black/60 mb-6">Keep the login surface small and easy to manage.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Session Timeout</label>
                    <x-ui.select class="cms-select">
                        <option>30 minutes</option>
                        <option>1 hour</option>
                        <option>2 hours</option>
                    </x-ui.select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Login Security</label>
                    <x-ui.select class="cms-select">
                        <option>Require strong password</option>
                        <option>Require strong password + device review</option>
                    </x-ui.select>
                </div>
            </div>
        </div>

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Password Management</h3>
            <p class="text-sm text-brand-black/60 mb-6">Sensitive actions should require confirmation (backend later).</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Current Password</label>
                    <input type="password" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">New Password</label>
                    <input type="password" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Confirm Password</label>
                    <input type="password" class="cms-input">
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="button" class="btn-primary">Save Settings</button>
        </div>
    </form>
@endsection
