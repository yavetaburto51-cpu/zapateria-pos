<h1>Productos</h1>

<a href="{{ route('products.create') }}">Agregar producto</a>

<table border="1">
    <tr>
        <th>Modelo</th>
        <th>Talla</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>

    @foreach($products as $product)
    <tr>
        <td>{{ $product->model }}</td>
        <td>{{ $product->size }}</td>
        <td>{{ $product->sale_price }}</td>
        <td>{{ $product->stock }}</td>
    </tr>
    <td>
        <a href="{{ route('products.edit', $product->id) }}">Editar</a>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Eliminar</button>
        </form>
    </td>
    @endforeach
</table>