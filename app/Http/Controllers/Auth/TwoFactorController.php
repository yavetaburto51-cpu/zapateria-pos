<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Services\SecurityLogger;

class TwoFactorController extends Controller
{
    public function showEnableForm(Request $request)
    {
        $user = auth()->user();
        $google2fa = new Google2FA();

        if (!$user->two_factor_secret) {
            $user->two_factor_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('auth.two-factor-setup', [
            'secret' => $user->two_factor_secret,
            'qrCodeSvg' => $qrCodeSvg,
            'isEnabled' => !empty($user->two_factor_confirmed_at),
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = auth()->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            $user->two_factor_confirmed_at = now();
            $user->save();

            SecurityLogger::log('2FA_ENABLED', 'El usuario habilitó la autenticación de dos factores (2FA).');

            return redirect()->route('dashboard')->with('success', 'Autenticación de dos factores activada con éxito.');
        }

        return back()->with('error', 'Código 2FA inválido. Por favor intenta de nuevo.');
    }

    public function showChallenge()
    {
        return view('auth.two-factor-challenge');
    }

    public function verifyChallenge(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $userId = session('2fa:user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);
        $google2fa = new Google2FA();

        if ($user && $google2fa->verifyKey($user->two_factor_secret, $request->code)) {
            session()->forget('2fa:user_id');
            auth()->login($user, session('2fa:remember', false));

            SecurityLogger::log('2FA_VERIFIED', 'Verificación 2FA exitosa al iniciar sesión.');

            return redirect()->intended(route('dashboard'));
        }

        SecurityLogger::log('2FA_FAILED', 'Intento fallido de verificación 2FA.', [], 'warning');

        return back()->with('error', 'Código 2FA incorrecto.');
    }

    public function disable(Request $request)
    {
        $user = auth()->user();
        $user->two_factor_secret = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        SecurityLogger::log('2FA_DISABLED', 'El usuario desactivó la autenticación de dos factores.');

        return redirect()->route('dashboard')->with('success', 'Autenticación de dos factores desactivada.');
    }
}
