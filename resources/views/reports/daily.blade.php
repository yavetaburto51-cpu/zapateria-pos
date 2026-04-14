<h1>Corte de Caja - Hoy</h1>

<p><strong>Total vendido:</strong> ${{ number_format($total, 2) }}</p>
<p><strong>Número de ventas:</strong> {{ $count }}</p>
<p><strong>Promedio por venta:</strong> ${{ number_format($average, 2) }}</p>

<hr>

<h3>Ventas del día:</h3>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Total</th>
        <th>Fecha</th>
    </tr>

    @foreach($sales as $sale)
    <tr>
        <td>{{ $sale->id }}</td>
        <td>${{ number_format($sale->total, 2) }}</td>
        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
    </tr>
    @endforeach
</table>