<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Zapatería 3 Hermanos</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <nav class="bg-stone-900 text-white px-6 py-4 flex justify-between items-center shadow-lg">
        
        <h1 class="text-xl font-bold tracking-wide">
            👞 Zapatería 3 Hermanos
        </h1>

        <div class="space-x-6 text-sm">
            <a href="/products" class="hover:text-amber-400">Productos</a>
            <a href="/sales" class="hover:text-amber-400">Ventas</a>
            <a href="/sales/history" class="hover:text-amber-400">Historial</a>
            <a href="/reports/top-products" class="hover:text-amber-400">Reportes</a>
            <a href="/reports/daily" class="hover:text-amber-400">Corte</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button class="ml-4 bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">
            Salir
        </button>
    </form>

    </nav>

    <div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded-xl shadow-md">
        @yield('content')
    </div>

</body>
</html>