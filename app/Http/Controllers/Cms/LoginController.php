<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        if (session('cms_authenticated') === true) {
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

        $emailOk = $cmsEmail !== '' && hash_equals($cmsEmail, $validated['email']);
        $passwordOk = false;

        if ($cmsPasswordHash !== '') {
            $passwordOk = Hash::check($validated['password'], $cmsPasswordHash);
        } elseif ($cmsPassword !== '') {
            // Local/dev fallback only. Prefer CMS_PASSWORD_HASH.
            $passwordOk = hash_equals($cmsPassword, $validated['password']);
        }

        if (!($emailOk && $passwordOk)) {
            return back()
                ->withErrors(['login' => 'Invalid credentials.'])
                ->withInput(['email' => $validated['email']]);
        }

        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('cms.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('cms_authenticated');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cms.login')->with('status', 'Logged out.');
    }
}
