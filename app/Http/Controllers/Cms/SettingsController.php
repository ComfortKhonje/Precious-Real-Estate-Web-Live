<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Built 2026-09-02 — the Settings page (cms.settings.index route) was
 * previously a bare closure returning a static view with a form that had
 * no action, no method, no name attributes, and a plain (non-submit)
 * button. Nothing could ever be saved. This wires it to the existing
 * Setting model (simple key/value store, already had a migration but
 * nothing ever read or wrote to it) and adds a real password-change flow,
 * which didn't exist anywhere in the app before this.
 */
class SettingsController extends Controller
{
    public const KEYS = [
        'system_email',
        'timezone',
        'inquiry_email_destination',
        'default_property_status',
        'session_timeout_minutes',
    ];

    public function index(Request $request)
    {
        $settings = Setting::whereIn('key', self::KEYS)->pluck('value', 'key');

        return view('cms.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'system_email' => 'nullable|email',
            'timezone' => 'nullable|string|max:64',
            'inquiry_email_destination' => 'nullable|email',
            'default_property_status' => 'nullable|string|in:'.implode(',', \App\Models\Property::STATUSES),
            'session_timeout_minutes' => 'nullable|integer|min:5|max:1440',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('status', 'Settings saved.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update(['password' => $request->input('password')]);

        return back()->with('status', 'Password updated.');
    }
}
