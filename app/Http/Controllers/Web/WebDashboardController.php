<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WebDashboardController extends Controller
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {}

    // ─────────────────────────────────────────────────────────────
    // AUTH PAGES
    // ─────────────────────────────────────────────────────────────

    /**
     * Show login page. Redirect to dashboard if already logged in.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (session('auth_token')) {
            return redirect()->route('dashboard.index');
        }
        return view('dashboard.login');
    }

    /**
     * Handle login form POST.
     * Calls AuthRepository directly — no HTTP self-call.
     */
    public function handleLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:1',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Invalid email or password.'])
                    ->with('error', 'Invalid email or password.');
            }

            // Check email verification if enabled
            if (config('auth.require_email_verification', false) && ! $user->hasVerifiedEmail()) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Please verify your email address before logging in.'])
                    ->with('error', 'Please verify your email address before logging in.');
            }

            // Create Sanctum token
            $token = $user->createToken('dashboard_token')->plainTextToken;

            session([
                'auth_token' => $token,
                'auth_user'  => $user->toArray(),
            ]);

            return redirect()->route('dashboard.index')
                ->with('success', 'Welcome back, ' . $user->name . '!');

        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show register page. Redirect to dashboard if already logged in.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (session('auth_token')) {
            return redirect()->route('dashboard.index');
        }
        return view('dashboard.register');
    }

    /**
     * Handle register form POST.
     * Calls AuthRepository directly — no HTTP self-call.
     */
    public function handleRegister(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                  => 'required|string|min:2|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {
            // Create user directly via Eloquent
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Create Sanctum token
            $token = $user->createToken('dashboard_token')->plainTextToken;

            session([
                'auth_token' => $token,
                'auth_user'  => $user->toArray(),
            ]);

            return redirect()->route('dashboard.index')
                ->with('success', 'Account created! Welcome, ' . $user->name . '!');

        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withInput($request->only('name', 'email'))
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Logout — revoke the current Sanctum token, then clear session.
     */
    public function logout(Request $request): RedirectResponse
    {
        $token = session('auth_token');

        if ($token) {
            try {
                // Revoke token directly via Sanctum
                $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
                if ($user) {
                    $user->delete();
                }
            } catch (\Exception $e) {
                // Ignore token revoke errors — still clear session
            }
        }

        $request->session()->forget(['auth_token', 'auth_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login')
            ->with('success', 'You have been logged out successfully.');
    }

    // ─────────────────────────────────────────────────────────────
    // DASHBOARD PAGES (protected by web.auth middleware)
    // ─────────────────────────────────────────────────────────────

    public function index(): View
    {
        return view('dashboard.index');
    }

    public function products(): View
    {
        return view('dashboard.products');
    }

    public function categories(): View
    {
        return view('dashboard.categories');
    }

    public function brands(): View
    {
        return view('dashboard.brands');
    }

    public function units(): View
    {
        return view('dashboard.units');
    }

    public function taxes(): View
    {
        return view('dashboard.taxes');
    }

    public function warehouses(): View
    {
        return view('dashboard.warehouses');
    }

    public function suppliers(): View
    {
        return view('dashboard.suppliers');
    }

    public function customers(): View
    {
        return view('dashboard.customers');
    }

    public function purchases(): View
    {
        return view('dashboard.purchases');
    }
}
