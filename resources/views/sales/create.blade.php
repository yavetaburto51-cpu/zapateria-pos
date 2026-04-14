<h1>Nueva Venta</h1>

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    <label>Producto:</label>
    <select name="product_id">
        @foreach($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->model }} - ${{ $product->sale_price }}
            </option>
        @endforeach
    </select><br>

    <label>Cantidad:</label>
    <input type="number" name="quantity"><br><br>

    <button type="submit">Vender</button>
</form>