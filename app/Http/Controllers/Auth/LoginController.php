<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\IpAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * The "email" field accepts either the e-mail address or the login name.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Brute-force guard: 5 failures per account+IP lock that pair for 5 minutes, and
        // 20 failures from one IP (any accounts) lock that IP for 15 minutes.
        $throttleKey = Str::lower($data['email']).'|'.$request->ip();
        $ipKey = 'login-ip|'.$request->ip();
        foreach ([[$throttleKey, 5], [$ipKey, 20]] as [$key, $max]) {
            if (RateLimiter::tooManyAttempts($key, $max)) {
                IpAudit::record('Too Many Login Attempts');

                throw ValidationException::withMessages([
                    'email' => 'Too many login attempts. Try again in '.RateLimiter::availableIn($key).' seconds.',
                ]);
            }
        }

        $field = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = [$field => $data['email'], 'password' => $data['password'], 'status' => true];

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($throttleKey, 300);
            RateLimiter::hit($ipKey, 900);
            IpAudit::record('Failed Login');

            throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        $now = now();
        $request->user()->forceFill(['last_login_at' => $now])->save();
        $request->session()->put('login_time', $now->format('Y-m-d H:i:s'));
        ActivityLog::record('Logged In '.$request->user()->email);

        return redirect()->intended($request->user()->canModule('inventory') ? route('inventory.dashboard') : route('welcome'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        if ($request->user()) {
            ActivityLog::record('Logged Out '.$request->user()->email);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
