@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Editar Producto</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-4">

        <input type="text" name="model" value="{{ $product->model }}"
            class="border p-2 rounded w-full" required>

        <input type="number" name="size" value="{{ $product->size }}"
            class="border p-2 rounded w-full" required>

        <input type="text" name="gender" value="{{ $product->gender }}"
            class="border p-2 rounded w-full">

        <input type="text" name="color" value="{{ $product->color }}"
            class="border p-2 rounded w-full">

        <input type="number" step="0.01" name="purchase_price" value="{{ $product->purchase_price }}"
            class="border p-2 rounded w-full" required>

        <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}"
            class="border p-2 rounded w-full" required>

        <input type="number" name="stock" value="{{ $product->stock }}"
            class="border p-2 rounded w-full" required>

    </div>

    <div class="mt-6 text-right">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            Actualizar Producto
        </button>
    </div>

</form>

@endsection