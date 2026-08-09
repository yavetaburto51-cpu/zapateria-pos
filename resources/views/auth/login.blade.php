<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-semibold text-slate-900">Accede a tu panel Zapatería</h1>
            <p class="mt-2 text-sm text-slate-600">Inicia sesión para gestionar ventas, inventario y clientes con una interfaz clara y moderna.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-4 rounded-[1.75rem] border border-slate-200 bg-slate-50/90 p-6 shadow-sm shadow-slate-200/50">
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="!text-black font-bold text-sm" />
                    <x-text-input id="email" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 !text-black font-medium shadow-sm focus:border-amber-400 focus:ring-amber-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="!text-black font-bold text-sm" />
                    <x-text-input id="password" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 !text-black font-medium shadow-sm focus:border-amber-400 focus:ring-amber-200" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <div class="flex items-center justify-between text-sm text-slate-600">
                <label for="remember_me" class="inline-flex items-center gap-2">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-400" name="remember">
                    {{ __('Recordarme') }}
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-medium text-amber-700 hover:text-amber-900">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <div class="grid gap-4">
                <x-primary-button class="w-full rounded-2xl bg-slate-900 py-3 text-base font-semibold text-white hover:bg-slate-800">
                    {{ __('Entrar') }}
                </x-primary-button>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-3 text-base font-semibold text-slate-900 transition hover:border-slate-400 hover:bg-slate-50">
                    Crear nueva cuenta
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
