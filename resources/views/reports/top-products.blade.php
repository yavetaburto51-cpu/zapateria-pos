@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Productos Más Vendidos</h1>

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