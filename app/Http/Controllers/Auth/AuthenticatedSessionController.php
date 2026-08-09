<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\SecurityLogger;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Si el usuario tiene 2FA ya habilitado, desautenticar temporalmente y solicitar el desafío 2FA.
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            session(['2fa:user_id' => $user->id, '2fa:remember' => $request->boolean('remember')]);
            Auth::logout();
            SecurityLogger::log('AUTH_2FA_REQUIRED', 'Credenciales correctas; solicitando código 2FA.');
            return redirect()->route('2fa.challenge');
        }

        // Si el usuario aún no tiene 2FA configurado, forzar onboarding antes de permitir acceso completo.
        if (! $user->two_factor_confirmed_at) {
            $request->session()->put('2fa:pending_setup', true);
            $request->session()->regenerate();
            SecurityLogger::log('AUTH_2FA_ONBOARDING', 'Inicio de sesión exitoso; forzando configuración de 2FA.');
            return redirect()->route('2fa.setup');
        }

        $request->session()->regenerate();

        SecurityLogger::log('AUTH_SUCCESS', 'Inicio de sesión exitoso.');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        SecurityLogger::log('AUTH_LOGOUT', 'Cierre de sesión.');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
