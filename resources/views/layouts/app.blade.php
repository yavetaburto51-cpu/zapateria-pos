<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Zapatería 3 Hermanos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <nav class="bg-stone-900 text-white px-6 py-4 shadow-lg">
        <div class="flex justify-between items-center">
            <a href="/dashboard" class="hover:text-amber-400">Home</a>
            <h1 class="text-xl font-bold tracking-wide text-center flex-1">
                👞 Zapatería 3 Hermanos
            </h1>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded-xl shadow-md">
        @yield('content')
    </div>

    @yield('scripts')

</body>
</html>