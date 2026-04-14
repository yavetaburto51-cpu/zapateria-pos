@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Historial de Ventas</h1>

@if($sales->count() > 0)

    @foreach($sales as $sale)
    <div class="bg-white shadow-md rounded-xl p-5 mb-6 border">

        <!-- ENCABEZADO -->
        <div class="flex justify-between items-center mb-3">
            <div>
                <h2 class="text-lg font-bold text-stone-800">
                    Venta #{{ $sale->id }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $sale->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-600">Total</p>
                <h2 class="text-xl font-bold text-green-600">
                    ${{ number_format($sale->total, 2) }}
                </h2>
            </div>
        </div>

        <!-- USUARIO -->
        <p class="text-sm text-gray-600 mb-2">
            Atendió: <span class="font-semibold">{{ $sale->user->name }}</span>
        </p>

        <!-- PRODUCTOS -->
        <table class="w-full border rounded overflow-hidden text-sm">
            <thead class="bg-stone-800 text-white">
                <tr>
                    <th class="p-2">Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sale->details as $detail)
                <tr class="text-center border-t hover:bg-stone-100">
                    <td class="p-2">{{ $detail->product->model }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->price, 2) }}</td>
                    <td>
                        ${{ number_format($detail->price * $detail->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- BOTÓN TICKET -->
        <div class="text-right mt-3">
            <a href="{{ route('sales.ticket', $sale->id) }}"
               class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded shadow text-sm">
                Descargar Ticket
            </a>
        </div>

    </div>
    @endforeach

@else
    <p class="text-gray-500">No hay ventas registradas</p>
@endif

@endsection