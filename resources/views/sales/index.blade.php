@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Nueva Venta</h1>

<h3 class="mb-2 font-semibold">Agregar producto</h3>

<form action="{{ route('cart.add') }}" method="POST" class="flex gap-4 mb-6">
    @csrf

    <select name="product_id" class="border p-2 rounded w-full">
        @foreach($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->model }} - ${{ $product->sale_price }}
            </option>
        @endforeach
    </select>

    <input type="number" name="quantity" class="border p-2 rounded w-32" placeholder="Cantidad" required>

    <button class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded shadow">
        Agregar
    </button>
</form>

<hr class="mb-4">

<h3 class="mb-2 font-semibold">Carrito</h3>

@php $total = 0; @endphp

@if(count($cart) > 0)
<table class="w-full border shadow rounded overflow-hidden">
    <thead class="bg-stone-800 text-white">
        <tr>
            <th class="p-2">Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($cart as $id => $item)
            @php 
                $subtotal = $item['price'] * $item['quantity']; 
                $total += $subtotal; 
            @endphp

        <tr class="text-center border-t hover:bg-stone-100">
            <td class="p-2">{{ $item['model'] }}</td>
            <td>${{ number_format($item['price'], 2) }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>${{ number_format($subtotal, 2) }}</td>
            <td>
                <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <button class="text-red-500 hover:text-red-700 font-bold">X</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-right mt-4">
    <h2 class="text-xl font-bold">
        Total: ${{ number_format($total, 2) }}
    </h2>

    <form action="{{ route('sales.confirm') }}" method="POST">
        @csrf
        <button class="mt-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
            Confirmar Venta
        </button>
    </form>
</div>

@else
    <p class="text-gray-500">El carrito está vacío</p>
@endif

@endsection