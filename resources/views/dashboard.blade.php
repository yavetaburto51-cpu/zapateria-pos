@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Panel de Control</h1>

<!-- ACCESOS RÁPIDOS -->
<div class="grid grid-cols-4 gap-4 mb-8">

    @if(auth()->user()->isEmployee() || auth()->user()->isAdmin())
    <a href="/sales" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Nueva Venta
    </a>
    @endif

    @if(auth()->user()->isManager() || auth()->user()->isAdmin())
    <a href="/products" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Productos
    </a>
    @endif

    @if(auth()->user()->isManager() || auth()->user()->isOwner() || auth()->user()->isAdmin())
    <a href="/sales/history" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Historial
    </a>
    @endif

    @if(auth()->user()->isManager() || auth()->user()->isAdmin())
    <a href="/reports/daily" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Corte
    </a>
    @endif

    @if(auth()->user()->isManager() || auth()->user()->isOwner() || auth()->user()->isAdmin())
    <a href="/reports/top-products" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Reportes
    </a>
    @endif

    @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
    <a href="/users" class="bg-stone-800 text-white p-4 rounded-lg text-center hover:bg-stone-700">
         Usuarios
    </a>
    @endif

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