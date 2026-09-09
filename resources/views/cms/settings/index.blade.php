@extends('layouts.cms')

@section('title', 'Settings | PREC CMS')
@section('page_title', 'Settings')
@section('page_subtitle', 'Operational preferences and access security.')

@section('content')
    {{-- Result now shows as a global toast (bottom-right) — see
         x-shared.toast-container in the CMS layout. --}}

    <form method="POST" action="{{ route('cms.settings.profile') }}" class="space-y-6 mb-6">
        @csrf
        @method('PUT')

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Profile Settings</h3>
            <p class="text-sm text-brand-black/60 mb-6">Your own name and email — shown in the CMS header and used to log in.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="cms-input">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="cms-input">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="submit" class="btn-primary">Save Profile</button>
        </div>
    </form>

    <form method="POST" action="{{ route('cms.settings.update') }}" class="space-y-6 mb-6">
        @csrf
        @method('PUT')

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Operational Preferences</h3>
            <p class="text-sm text-brand-black/60 mb-6">Only backend-facing preferences live here. Main website branding stays controlled in the frontend.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">System Email</label>
                    <input type="email" name="system_email" value="{{ old('system_email', $settings['system_email'] ?? '') }}" placeholder="admin@preciousrealestate.mw" class="cms-input">
                    @error('system_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Time Zone</label>
                    <input type="text" name="timezone" value="{{ old('timezone', $settings['timezone'] ?? 'Africa/Blantyre') }}" placeholder="Africa/Blantyre" class="cms-input">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Inquiry Email Destination</label>
                    <input type="email" name="inquiry_email_destination" value="{{ old('inquiry_email_destination', $settings['inquiry_email_destination'] ?? '') }}" placeholder="info@preciousrealestate.mw" class="cms-input">
                    @error('inquiry_email_destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-brand-black/50 mt-1">Every inquiry and contact-page submission emails a notification here. Leave blank to use the site default (info@preciousrealestate.mw).</p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Default Property Status</label>
                    <select name="default_property_status" class="cms-select">
                        @foreach(\App\Models\Property::STATUSES as $status)
                            <option value="{{ $status }}" {{ old('default_property_status', $settings['default_property_status'] ?? 'For Sale') === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="submit" class="btn-primary">Save Settings</button>
        </div>
    </form>

    <div class="cms-panel p-6 mb-6">
        <div class="flex items-center justify-between gap-4 mb-1">
            <h3 class="cms-section-title">Site Status</h3>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $isDownForMaintenance ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                <span class="w-2 h-2 rounded-full {{ $isDownForMaintenance ? 'bg-red-500' : 'bg-green-500' }}"></span>
                {{ $isDownForMaintenance ? 'Under Maintenance' : 'Live' }}
            </span>
        </div>
        <p class="text-sm text-brand-black/60 mb-6">
            @if($isDownForMaintenance)
                Visitors see a "We'll be right back" page. The CMS stays reachable so you can keep working and switch it back.
            @else
                The public site is visible to everyone. Turn this on before major changes you don't want visitors to see mid-edit.
            @endif
        </p>

        <form id="maintenance-toggle-form" method="POST" action="{{ route('cms.settings.maintenance') }}">
            @csrf
            @if($isDownForMaintenance)
                <button type="submit" class="btn-primary">Bring Site Back Online</button>
            @else
                <button type="button" class="btn-danger"
                    @click="confirmFormId = 'maintenance-toggle-form'; confirmTitle = 'Enable Maintenance Mode?'; confirmMessage = 'This takes the public website offline for every visitor immediately. The CMS stays reachable so you can switch it back here. Continue?'; confirmActionLabel = 'Yes, Enable'; confirmLoadingLabel = 'Enabling&hellip;'; confirmModalOpen = true">
                    Enable Maintenance Mode
                </button>
            @endif
        </form>
    </div>

    <form method="POST" action="{{ route('cms.settings.password') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Password Management</h3>
            <p class="text-sm text-brand-black/60 mb-6">Change the password for your own CMS login ({{ auth()->user()->email }}).</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Current Password</label>
                    <input type="password" name="current_password" class="cms-input">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">New Password</label>
                    <input type="password" name="password" class="cms-input">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="cms-input">
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="submit" class="btn-primary">Update Password</button>
        </div>
    </form>
@endsection
