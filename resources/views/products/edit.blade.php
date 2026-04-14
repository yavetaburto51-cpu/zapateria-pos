<h1>Editar Producto</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Modelo:</label>
    <input type="text" name="model" value="{{ $product->model }}"><br>

    <label>Talla:</label>
    <input type="text" name="size" value="{{ $product->size }}"><br>

    <label>Género:</label>
    <input type="text" name="gender" value="{{ $product->gender }}"><br>

    <label>Color:</label>
    <input type="text" name="color" value="{{ $product->color }}"><br>

    <label>Precio Compra:</label>
    <input type="number" step="0.01" name="purchase_price" value="{{ $product->purchase_price }}"><br>

    <label>Precio Venta:</label>
    <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}"><br>

    <label>Stock:</label>
    <input type="number" name="stock" value="{{ $product->stock }}"><br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="{{ route('products.index') }}">Volver</a>