<h1>Ventas</h1>

<h3>Agregar producto</h3>

<form action="{{ route('cart.add') }}" method="POST">
    @csrf

    <select name="product_id">
        @foreach($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->model }} - ${{ $product->sale_price }}
            </option>
        @endforeach
    </select>

    <input type="number" name="quantity" placeholder="Cantidad">

    <button type="submit">Agregar</button>
</form>

<hr>

<h3>Carrito</h3>

<table border="1">
    <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Total</th>
        <th></th>
    </tr>

    @php $total = 0; @endphp

    @foreach($cart as $id => $item)
    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
    <tr>
        <td>{{ $item['model'] }}</td>
        <td>{{ $item['price'] }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>{{ $subtotal }}</td>
        <td>
            <form action="{{ route('cart.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $id }}">
                <button type="submit">X</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<h3>Total: ${{ $total }}</h3>

<form action="{{ route('sales.confirm') }}" method="POST">
    @csrf
    <button type="submit">Confirmar venta</button>
</form>