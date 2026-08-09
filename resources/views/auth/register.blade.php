<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <h1 class="text-3xl font-semibold text-slate-900">Regístrate en Zapatería POS</h1>
            <p class="mt-2 text-sm text-slate-600">Crea tu cuenta y comienza a gestionar ventas, inventario y clientes con una experiencia clara y confiable.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div class="space-y-4 rounded-[1.75rem] border border-slate-200 bg-slate-50/90 p-6 shadow-sm shadow-slate-200/50">
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" class="text-sm font-semibold text-slate-700" />
                    <x-text-input id="name" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-amber-400 focus:ring-amber-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" class="text-sm font-semibold text-slate-700" />
                    <x-text-input id="email" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-amber-400 focus:ring-amber-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="text-sm font-semibold text-slate-700" />
                    <x-text-input id="password" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-amber-400 focus:ring-amber-200" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-sm font-semibold text-slate-700" />
                    <x-text-input id="password_confirmation" class="block mt-2 w-full rounded-2xl border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-amber-400 focus:ring-amber-200" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <div class="grid gap-4">
                <x-primary-button class="w-full rounded-2xl bg-amber-500 py-3 text-base font-semibold text-white hover:bg-amber-600">
                    {{ __('Crear cuenta') }}
                </x-primary-button>

                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-3 text-base font-semibold text-slate-900 transition hover:border-slate-400 hover:bg-slate-50">
                    Ya tengo cuenta
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
