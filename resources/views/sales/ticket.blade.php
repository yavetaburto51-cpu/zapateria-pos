<h2 style="text-align:center;">Zapatería 3 Hermanos</h2>

<p><strong>Venta #:</strong> {{ $sale->id }}</p>
<p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Atendió:</strong> {{ $sale->user->name }}</p>

<hr>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Producto</th>
        <th>Cant.</th>
        <th>Precio</th>
        <th>Total</th>
    </tr>

    @foreach($sale->details as $detail)
    <tr>
        <td>{{ $detail->product->model }}</td>
        <td>{{ $detail->quantity }}</td>
        <td>${{ number_format($detail->price, 2) }}</td>
        <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
    </tr>
    @endforeach
</table>

<hr>

<h3>Total: ${{ number_format($sale->total, 2) }}</h3>

<p style="text-align:center;">¡Gracias por su compra!</p>