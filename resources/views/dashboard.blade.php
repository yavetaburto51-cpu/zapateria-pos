@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Panel de Control</h1>

<!-- RESUMEN -->
<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-green-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Ventas del día</p>
        <h2 class="text-2xl font-bold">${{ number_format($totalToday, 2) }}</h2>
    </div>

    <div class="bg-blue-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Número de ventas</p>
        <h2 class="text-2xl font-bold">{{ $countToday }}</h2>
    </div>

    <div class="bg-amber-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Promedio</p>
        <h2 class="text-2xl font-bold">
            ${{ $countToday > 0 ? number_format($totalToday / $countToday, 2) : 0 }}
        </h2>
    </div>

</div>

<!-- ACCESOS RÁPIDOS -->
<div class="grid grid-cols-4 gap-4 mb-8">

    <a href="/sales" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
        🛒 Nueva Venta
    </a>

    <a href="/products" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
        📦 Productos
    </a>

    <a href="/sales/history" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
        📊 Historial
    </a>

    <a href="/reports/daily" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
        💰 Corte
    </a>

</div>

<!-- STOCK BAJO -->
<h2 class="text-xl font-bold mb-3">⚠ Productos con bajo stock</h2>

@if($lowStock->count() > 0)
<table class="w-full border shadow rounded">
    <thead class="bg-red-500 text-white">
        <tr>
            <th class="p-2">Producto</th>
            <th>Stock</th>
        </tr>
    </thead>

    <tbody>
        @foreach($lowStock as $product)
        <tr class="text-center border-t">
            <td class="p-2">{{ $product->model }}</td>
            <td class="text-red-600 font-bold">{{ $product->stock }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="text-gray-500">No hay productos con bajo stock</p>
@endif

@endsection