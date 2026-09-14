<?php

namespace App\Http\Controllers\Cms;

use App\Console\Commands\PostDeploy;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
    ];

    public function index(Request $request)
    {
        $settings = Setting::whereIn('key', self::KEYS)->pluck('value', 'key');
        $isDownForMaintenance = app()->isDownForMaintenance();
        $deploy = PostDeploy::status();

        return view('cms.settings.index', compact('settings', 'isDownForMaintenance', 'deploy'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'system_email' => 'nullable|email',
            'timezone' => 'nullable|string|max:64',
            'inquiry_email_destination' => 'nullable|email',
            'default_property_status' => 'nullable|string|in:'.implode(',', \App\Models\Property::STATUSES),
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('status', 'Settings saved.');
    }

    /**
     * Update the logged-in staff member's own name/email. There was no way
     * to do this anywhere in the CMS — Settings only ever covered app-wide
     * preferences and this user's password, never their own profile.
     */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
        ]);

        $request->user()->update($data);

        return back()->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => $request->input('password'),
            'must_change_password' => false,
        ]);

        return redirect()->route('cms.settings.index')->with('status', 'Password updated.');
    }

    /**
     * Sends a plain test message through the live mail settings, so SMTP
     * problems show up here — not as silently missing inquiry emails.
     */
    public function sendTestEmail(Request $request)
    {
        $to = $request->user()->email;

        try {
            Mail::raw(
                "This is a test email from the ".config('app.name')." CMS.\n\nIf you're reading this, outgoing email works — inquiry and contact-form notifications will be delivered.",
                fn ($message) => $message->to($to)->subject('PREC CMS test email')
            );
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Sending failed: '.Str::limit($e->getMessage(), 200));
        }

        return back()->with('status', "Test email sent to {$to}. Check the inbox (and spam folder).");
    }

    /**
     * Flip the public site between live and maintenance mode.
     *
     * `down` itself has no "except" option — the CMS staying reachable
     * comes from bootstrap/app.php's
     * $middleware->preventRequestsDuringMaintenance(['cms/*']). Without
     * that, the very first request after enabling maintenance mode
     * (loading this page again, or even /cms/login) would 503 too, and
     * there'd be no way back in except SSH/Terminal access to run
     * `php artisan up` directly.
     */
    public function toggleMaintenance(Request $request)
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');

            return back()->with('status', 'Site is back online.');
        }

        Artisan::call('down', ['--retry' => 60]);

        return back()->with('status', 'Site is now in maintenance mode. The CMS stays reachable.');
    }
}
