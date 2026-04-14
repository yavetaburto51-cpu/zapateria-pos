@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Productos</h1>

<a href="{{ route('products.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">
    Agregar producto
</a>

<table class="w-full mt-4 border rounded-lg overflow-hidden shadow-sm">
    <thead class="bg-stone-800 text-white">
        <tr>
            <th class="p-2">Modelo</th>
            <th>Talla</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
        <tr class="text-center border-t hover:bg-stone-100">
            <td class="p-2">{{ $product->model }}</td>
            <td>{{ $product->size }}</td>
            <td>{{ $product->color }}</td>
            <td>${{ $product->sale_price }}</td>
            <td>
                <span class="px-2 py-1 rounded 
                    {{ $product->stock < 5 ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' }}">
                    {{ $product->stock }}
                </span>
            </td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500">Editar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection