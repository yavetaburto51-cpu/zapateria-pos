<h1>Agregar Producto</h1>

<form action="{{ route('products.store') }}" method="POST">


    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color:red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    @csrf

    <label>Modelo:</label>
    <input type="text" name="model"><br>

    <label>Talla:</label>
    <input type="text" name="size"><br>

    <label>Género:</label>
    <input type="text" name="gender"><br>

    <label>Color:</label>
    <input type="text" name="color"><br>

    <label>Precio Compra:</label>
    <input type="number" step="0.01" name="purchase_price"><br>

    <label>Precio Venta:</label>
    <input type="number" step="0.01" name="sale_price"><br>

    <label>Stock:</label>
    <input type="number" name="stock"><br><br>

    <button type="submit">Guardar</button>
</form>

<a href="{{ route('products.index') }}">Volver</a>