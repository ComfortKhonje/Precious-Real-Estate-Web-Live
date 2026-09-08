@extends('layouts.cms')

@section('title', 'Settings | PREC CMS')
@section('page_title', 'Settings')
@section('page_subtitle', 'Operational preferences and access security.')

@section('content')
    {{-- Result now shows as a global toast (bottom-right) — see
         x-shared.toast-container in the CMS layout. --}}

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

        <div class="cms-panel p-6">
            <h3 class="cms-section-title mb-1">Access & Notifications</h3>
            <p class="text-sm text-brand-black/60 mb-6">Keep the login surface small and easy to manage.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold tracking-wider">Session Timeout (minutes)</label>
                    <input type="number" name="session_timeout_minutes" min="5" max="1440" value="{{ old('session_timeout_minutes', $settings['session_timeout_minutes'] ?? 120) }}" class="cms-input">
                    <p class="text-xs text-brand-black/40">Stored for reference — actually changing session behavior needs a code change to `config/session.php` (`SESSION_LIFETIME`), not wired to this value automatically.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <button type="submit" class="btn-primary">Save Settings</button>
        </div>
    </form>

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
