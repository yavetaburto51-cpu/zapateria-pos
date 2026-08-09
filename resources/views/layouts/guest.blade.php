<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-amber-50 via-slate-50 to-slate-100">
            <div class="w-full sm:max-w-xl">
                <div class="flex justify-center mb-6">
                    <a href="/" class="inline-flex items-center gap-3 rounded-full bg-white/90 px-4 py-3 text-slate-900 shadow-sm ring-1 ring-slate-200 transition hover:bg-white">
                        <x-application-logo class="w-12 h-12 text-amber-500" />
                        <span class="text-lg font-semibold tracking-tight">Zapatería POS</span>
                    </a>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white/95 p-6 shadow-[0_25px_60px_-35px_rgba(15,23,42,0.35)] backdrop-blur-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
