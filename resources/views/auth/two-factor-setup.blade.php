@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Configurar Autenticación de Dos Factores (2FA / TOTP)</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($isEnabled)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            ✓ La autenticación de dos factores está actualmente <strong>ACTIVADA</strong> en tu cuenta.
        </div>
        <form action="{{ route('2fa.disable') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                Desactivar 2FA
            </button>
        </form>
    @else
        <p class="mb-4 text-gray-700">
            Escanea el siguiente código QR con tu aplicación Authenticator (Google Authenticator, Authy, Microsoft Authenticator) o ingresa la clave secreta manualmente.
        </p>

        <div class="flex justify-center mb-4 p-4 bg-gray-50 border rounded">
            {!! $qrCodeSvg !!}
        </div>

        <p class="text-sm text-gray-600 mb-6 text-center">
            Clave secreta manual: <code class="bg-gray-200 px-2 py-1 rounded font-mono font-bold">{{ $secret }}</code>
        </p>

        <form action="{{ route('2fa.enable') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Código de verificación (6 dígitos)</label>
                <input type="text" name="code" id="code" maxlength="6" class="mt-1 block w-full border p-2 rounded shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="123456" required autocomplete="off">
            </div>

            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded shadow">
                Confirmar y Activar 2FA
            </button>
        </form>
    @endif
</div>
@endsection
