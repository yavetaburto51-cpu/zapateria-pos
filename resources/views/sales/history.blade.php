<h1>Historial de Ventas</h1>

@foreach($sales as $sale)
    <div style="border:1px solid black; margin-bottom:10px; padding:10px;">
        
        <strong>Venta #{{ $sale->id }}</strong><br>
        Usuario: {{ $sale->user->name }}<br>
        Fecha: {{ $sale->created_at->format('d/m/Y H:i') }}<br>
        Total: ${{ $sale->total }}

        <h4>Productos:</h4>
        <ul>
            @foreach($sale->details as $detail)
                <li>
                    {{ $detail->product->model }} 
                    - Cantidad: {{ $detail->quantity }} 
                    - ${{ $detail->price }}
                </li>
            @endforeach
        </ul>

        <a href="{{ route('sales.ticket', $sale->id) }}">Descargar Ticket</a>

    </div>
@endforeach