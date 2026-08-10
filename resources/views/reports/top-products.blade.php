@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-stone-800">Reportes Generales</h1>

<!-- INDICADORES DEL DÍA -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-green-50 border border-green-200 p-6 rounded-xl shadow-sm text-center">
        <p class="text-sm font-medium text-green-700 uppercase tracking-wide">Ventas del día</p>
        <h2 class="text-3xl font-extrabold text-green-900 mt-1">${{ number_format($totalToday, 2) }}</h2>
    </div>

    <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl shadow-sm text-center">
        <p class="text-sm font-medium text-blue-700 uppercase tracking-wide">Número de ventas</p>
        <h2 class="text-3xl font-extrabold text-blue-900 mt-1">{{ $countToday }}</h2>
    </div>

    <div class="bg-amber-50 border border-amber-200 p-6 rounded-xl shadow-sm text-center">
        <p class="text-sm font-medium text-amber-700 uppercase tracking-wide">Promedio por venta</p>
        <h2 class="text-3xl font-extrabold text-amber-900 mt-1">
            ${{ $countToday > 0 ? number_format($averageToday, 2) : '0.00' }}
        </h2>
    </div>
</div>

<!-- GRÁFICA SEMANAL AUTOCONTENIDA -->
@php
    $maxSale = max(array_merge($weeklySales, [1]));
    $weeklyTotalSum = array_sum($weeklySales);
@endphp

<div class="bg-white p-6 rounded-xl shadow-md border border-stone-200 mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
        <div>
            <h2 class="text-xl font-bold text-stone-800">📊 Ventas Semanales</h2>
            <p class="text-xs text-stone-500">Monto facturado día a día en los últimos 7 días</p>
        </div>
        <span class="text-xs font-semibold px-3 py-1.5 bg-amber-100 text-amber-800 rounded-full border border-amber-200">
            Total 7 días: ${{ number_format($weeklyTotalSum, 2) }}
        </span>
    </div>

    <!-- Gráfica de Barras Nativa (HTML/CSS) - 100% visible sin dependencias CDN -->
    <div class="w-full pt-4 pb-2">
        <div class="h-64 flex items-end justify-between gap-2 sm:gap-4 border-b border-stone-200 pb-2 px-2">
            @foreach($weeklySales as $index => $amount)
                @php
                    $percentage = $maxSale > 0 ? min(100, max(6, ($amount / $maxSale) * 100)) : 6;
                    $label = $weeklyLabels[$index] ?? '';
                @endphp
                <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
                    <!-- Tooltip al pasar el cursor -->
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-stone-900 text-white text-xs rounded py-1 px-2.5 absolute -top-9 z-20 whitespace-nowrap shadow-lg pointer-events-none">
                        {{ $label }}: ${{ number_format($amount, 2) }}
                    </div>

                    <!-- Etiqueta del valor -->
                    <span class="text-[11px] font-bold text-stone-600 mb-1.5">
                        ${{ $amount > 0 ? number_format($amount, 0) : '0' }}
                    </span>

                    <!-- Barra con Gradiente -->
                    <div class="w-full max-w-[48px] bg-gradient-to-t from-amber-500 to-amber-400 group-hover:from-amber-600 group-hover:to-amber-500 rounded-t-md transition-all duration-300 shadow-sm"
                         style="height: {{ $percentage }}%;">
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Fechas en el Eje X -->
        <div class="flex justify-between gap-2 sm:gap-4 px-2 mt-3">
            @foreach($weeklyLabels as $label)
                <div class="flex-1 text-center">
                    <span class="text-xs font-semibold text-stone-500">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- STOCK BAJO -->
<h2 class="text-xl font-bold mb-3 text-stone-800">⚠ Productos con bajo stock</h2>
@if($lowStock->count() > 0)
<div class="overflow-x-auto mb-8 shadow-sm rounded-lg border border-stone-200">
    <table class="w-full text-sm">
        <thead class="bg-red-500 text-white">
            <tr>
                <th class="p-3 text-left">Producto</th>
                <th class="p-3 text-center">Stock</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-200 bg-white">
            @foreach($lowStock as $product)
            <tr class="hover:bg-red-50">
                <td class="p-3 font-medium text-stone-800">{{ $product->model }}</td>
                <td class="p-3 text-center text-red-600 font-bold">{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p class="text-gray-500 mb-8 bg-stone-50 p-4 rounded-lg border border-stone-200">No hay productos con bajo stock</p>
@endif

<!-- PRODUCTOS MÁS VENDIDOS -->
<h2 class="text-xl font-bold mb-3 text-stone-800">🏆 Productos Más Vendidos</h2>
@if($products->count() > 0)
<div class="overflow-x-auto shadow-sm rounded-lg border border-stone-200">
    <table class="w-full text-sm">
        <thead class="bg-stone-800 text-white">
            <tr>
                <th class="p-3 text-left w-16">#</th>
                <th class="p-3 text-left">Producto</th>
                <th class="p-3 text-center">Total Vendido</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-200 bg-white">
            @foreach($products as $index => $product)
            <tr class="hover:bg-stone-50">
                <td class="p-3 font-bold text-stone-500">{{ $index + 1 }}</td>
                <td class="p-3 font-semibold text-stone-800">👞 {{ $product->model }}</td>
                <td class="p-3 text-center font-bold text-green-600">{{ $product->total_sold }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p class="text-gray-500 bg-stone-50 p-4 rounded-lg border border-stone-200">No hay datos de ventas aún</p>
@endif

@endsection