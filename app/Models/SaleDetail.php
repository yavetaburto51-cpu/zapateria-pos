<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);

            // Validar stock
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Stock insuficiente');
            }

            // Crear venta
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $product->sale_price * $request->quantity
            ]);

            // Detalle
            SaleDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->sale_price
            ]);

            // Descontar stock
            $product->stock -= $request->quantity;
            $product->save();

            DB::commit();

            return redirect()->back()->with('success', 'Venta realizada');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error en la venta');
        }
    }

}
