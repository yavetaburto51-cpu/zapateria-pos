@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Reportes Generales</h1>

<!-- INDICADORES DEL DÍA -->
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
            ${{ $countToday > 0 ? number_format($averageToday, 2) : 0 }}
        </h2>
    </div>
</div>

<!-- GRÁFICA SEMANAL -->
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="text-xl font-bold mb-4">Ventas Semanales</h2>
    <canvas id="weeklySalesChart" width="400" height="200"></canvas>
</div>

<!-- STOCK BAJO -->
<h2 class="text-xl font-bold mb-3">⚠ Productos con bajo stock</h2>
@if($lowStock->count() > 0)
<table class="w-full border shadow rounded mb-8">
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
    <p class="text-gray-500 mb-8">No hay productos con bajo stock</p>
@endif

<!-- PRODUCTOS MÁS VENDIDOS -->
<h2 class="text-xl font-bold mb-3">Productos Más Vendidos</h2>
@if($products->count() > 0)
<table class="w-full border rounded-xl overflow-hidden shadow">
    <thead class="bg-stone-800 text-white">
        <tr>
            <th class="p-3 text-left">#</th>
            <th class="text-left">Producto</th>
            <th>Total Vendido</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $index => $product)
        <tr class="border-t hover:bg-stone-100">
            <td class="p-3 font-bold">
                {{ $index + 1 }}
            </td>
            <td>
                👞 {{ $product->model }}
            </td>
            <td class="text-center font-semibold text-green-600">
                {{ $product->total_sold }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="text-gray-500">No hay datos de ventas aún</p>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weeklySalesChart').getContext('2d');
    const weeklySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                '{{ \Carbon\Carbon::today()->subDays(6)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->subDays(5)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->subDays(4)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->subDays(3)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->subDays(2)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->subDays(1)->format('d/m') }}',
                '{{ \Carbon\Carbon::today()->format('d/m') }}'
            ],
            datasets: [{
                label: 'Ventas Diarias ($)',
                data: @json($weeklySales),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection