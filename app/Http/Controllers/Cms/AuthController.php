<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password as PasswordRule;

/**
 * CMS login, logout and self-service password reset. Moved out of inline
 * route closures 2026-09-14 when the reset flow was added — with no shell
 * access on the host, "forgot my password" can't be solved by someone
 * running an artisan command anymore.
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('cms.dashboard');
        }

        return view('cms.auth.login');
    }

    public function login(Request $request)
    {
        // Two limits: 5 tries per IP+email (one account being guessed) and
        // 20 per IP overall (one attacker rotating through emails).
        $accountKey = 'cms-login:'.$request->ip().'|'.strtolower((string) $request->input('email'));
        $ipKey = 'cms-login-ip:'.$request->ip();

        foreach ([$accountKey => 5, $ipKey => 20] as $key => $max) {
            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);

                return back()
                    ->withErrors(['login' => "Too many attempts. Try again in {$seconds} seconds."])
                    ->withInput(['email' => $request->input('email')]);
            }
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($accountKey, 60);
            RateLimiter::hit($ipKey, 60);

            return back()
                ->withErrors(['login' => 'Invalid credentials.'])
                ->withInput(['email' => $credentials['email']]);
        }

        RateLimiter::clear($accountKey);
        $request->session()->regenerate();

        return redirect()->intended(route('cms.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('cms.login')->with('status', 'Logged out.');
    }

    public function showForgot()
    {
        return view('cms.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        // Same answer whether or not the address has an account, so this
        // form can't be used to find out who has CMS access.
        try {
            Password::sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['email' => 'The reset email could not be sent right now. Please contact your administrator.']);
        }

        return back()->with('status', 'If that email has a CMS account, a reset link is on its way. It expires in 60 minutes.');
    }

    public function showReset(Request $request, string $token)
    {
        return view('cms.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'must_change_password' => false,
                ])->setRememberToken(null);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()
                ->withErrors(['email' => __($status)])
                ->withInput(['email' => $request->input('email')]);
        }

        return redirect()->route('cms.login')->with('status', 'Password updated. You can log in now.');
    }
}
