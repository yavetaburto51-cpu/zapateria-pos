@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Agregar Producto</h1>

<form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md">
    @csrf

    <div class="grid grid-cols-2 gap-4">

        <input type="text" name="model" placeholder="Modelo"
            class="border p-2 rounded w-full" required>

        <input type="number" name="size" placeholder="Talla"
            class="border p-2 rounded w-full" required>

        <input type="text" name="gender" placeholder="Género"
            class="border p-2 rounded w-full">

        <input type="text" name="color" placeholder="Color"
            class="border p-2 rounded w-full">

        <input type="number" step="0.01" name="purchase_price" placeholder="Precio compra"
            class="border p-2 rounded w-full" required>

        <input type="number" step="0.01" name="sale_price" placeholder="Precio venta"
            class="border p-2 rounded w-full" required>

        <input type="number" name="stock" placeholder="Stock"
            class="border p-2 rounded w-full" required>

    </div>

    <div class="mt-6 text-right">
        <button class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded shadow">
            Guardar Producto
        </button>
    </div>

</form>

@endsection