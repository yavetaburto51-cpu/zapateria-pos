@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Corte de Caja - Hoy</h1>

<!-- RESUMEN -->
<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-green-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Total vendido</p>
        <h2 class="text-2xl font-bold text-green-700">
            ${{ number_format($total, 2) }}
        </h2>
    </div>

    <div class="bg-blue-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Ventas realizadas</p>
        <h2 class="text-2xl font-bold text-blue-700">
            {{ $count }}
        </h2>
    </div>

    <div class="bg-amber-100 p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Promedio por venta</p>
        <h2 class="text-2xl font-bold text-amber-700">
            ${{ number_format($average, 2) }}
        </h2>
    </div>

</div>

<!-- TABLA -->
<h2 class="text-lg font-semibold mb-3">Ventas del día</h2>

@if($sales->count() > 0)
<table class="w-full border rounded-lg overflow-hidden shadow">

    <thead class="bg-stone-800 text-white">
        <tr>
            <th class="p-2">ID</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sales as $sale)
        <tr class="text-center border-t hover:bg-stone-100">
            <td class="p-2">{{ $sale->id }}</td>
            <td>${{ number_format($sale->total, 2) }}</td>
            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>

</table>
@else
    <p class="text-gray-500">No hay ventas hoy</p>
@endif

@endsection