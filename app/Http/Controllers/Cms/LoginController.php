<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        if (session('cms_authenticated') === true || Auth::check()) {
            return redirect()->route('cms.dashboard');
        }

        return view('cms.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $cmsEmail = (string) env('CMS_EMAIL', '');
        $cmsPasswordHash = (string) env('CMS_PASSWORD_HASH', '');
        $cmsPassword = (string) env('CMS_PASSWORD', '');

        $loginMessage = 'Invalid email or password.';
        $envConfigured = $cmsEmail !== '' && ($cmsPasswordHash !== '' || $cmsPassword !== '');

        if ($envConfigured) {
            $emailOk = hash_equals($cmsEmail, $validated['email']);
            $passwordOk = false;

            if ($cmsPasswordHash !== '') {
                $passwordOk = Hash::check($validated['password'], $cmsPasswordHash);
            } elseif ($cmsPassword !== '') {
                $passwordOk = hash_equals($cmsPassword, $validated['password']);
            }

            if ($emailOk && $passwordOk) {
                return $this->authenticateCmsSession($request);
            }

            // Continue to user table fallback if env credentials are present but fail.
            $loginMessage = 'Invalid email or password.';
        }

        $user = User::where('email', $validated['email'])->first();
        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::guard('web')->login($user);
            return $this->authenticateCmsSession($request);
        }

        if (! $envConfigured) {
            $loginMessage = 'CMS login is not configured. Please set CMS_EMAIL and CMS_PASSWORD or CMS_PASSWORD_HASH in .env.';
        }

        return back()
            ->withErrors(['login' => $loginMessage])
            ->withInput(['email' => $validated['email']]);
    }

    protected function authenticateCmsSession(Request $request)
    {
        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('cms.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->forget('cms_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('cms.login')->with('status', 'Logged out.');
    }
}
