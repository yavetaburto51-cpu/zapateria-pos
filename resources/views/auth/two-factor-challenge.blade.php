@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
    <h2 class="text-xl font-bold mb-4 text-center">Verificación de Seguridad (2FA)</h2>
    <p class="text-sm text-gray-600 mb-6 text-center">Ingresa el código de 6 dígitos generado por tu aplicación Authenticator.</p>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('2fa.challenge.verify') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Código Authenticator</label>
            <input type="text" name="code" id="code" maxlength="6" autofocus class="mt-1 block w-full text-center text-2xl tracking-widest border p-2 rounded shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="000000" required autocomplete="off">
        </div>

        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded shadow">
            Verificar e Iniciar Sesión
        </button>
    </form>
</div>
@endsection
