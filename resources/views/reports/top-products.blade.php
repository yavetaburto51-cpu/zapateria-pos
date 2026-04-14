<h1>Productos Más Vendidos</h1>

<table border="1">
    <tr>
        <th>Producto</th>
        <th>Total Vendido</th>
    </tr>

    @foreach($products as $product)
    <tr>
        <td>{{ $product->model }}</td>
        <td>{{ $product->total_sold }}</td>
    </tr>
    @endforeach
</table>