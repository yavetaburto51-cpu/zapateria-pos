<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function ticket($id)
    {
        $sale = Sale::with('details.product', 'user')->findOrFail($id);

        $pdf = Pdf::loadView('sales.ticket', compact('sale'));

        return $pdf->download('ticket_venta_'.$sale->id.'.pdf');
    }

    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);

        return view('sales.index', compact('products', 'cart'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
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

            // Crear detalle
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

            return redirect()->back()->with('success', 'Venta realizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error en la venta');
        }
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "model" => $product->model,
                "price" => $product->sale_price,
                "quantity" => $request->quantity
            ];
        }

        session()->put('cart', $cart);

        return back();
    }


    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart');

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function confirmSale()
    {
        DB::beginTransaction();

        try {
            $cart = session()->get('cart');

            if (!$cart || count($cart) == 0) {
                return back()->with('error', 'Carrito vacío');
            }

            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total
            ]);

            foreach ($cart as $productId => $item) {

                $product = Product::findOrFail($productId);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuficiente");
                }

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $product->stock -= $item['quantity'];
                $product->save();
            }

            session()->forget('cart');

            DB::commit();

            return back()->with('success', 'Venta completada');

        } catch (\Exception $e) {
            DB::rollBack();
            #return back()->with('error', $e->getMessage());
            dd($e->getMessage());
        }
    }

    public function history()
    {
        $sales = Sale::with('details.product', 'user')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('sales.history', compact('sales'));
    }


    public function topProducts()
    {
        $products = DB::table('sale_details')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->select(
                'products.model',
                DB::raw('SUM(sale_details.quantity) as total_sold')
            )
            ->groupBy('products.model')
            ->orderByDesc('total_sold')
            ->get();

        return view('reports.top-products', compact('products'));
    }

    public function dailyReport()
    {
        $today = Carbon::today();

        $sales = Sale::whereDate('created_at', $today)->get();

        $total = $sales->sum('total');
        $count = $sales->count();
        $average = $count > 0 ? $total / $count : 0;

        return view('reports.daily', compact('sales', 'total', 'count', 'average'));
    }

    public function dashboard()
    {
        $today = Carbon::today();

        $salesToday = Sale::whereDate('created_at', $today)->get();

        $totalToday = $salesToday->sum('total');
        $countToday = $salesToday->count();

        $lowStock = Product::where('stock', '<', 5)->get();

        return view('dashboard', compact('totalToday', 'countToday', 'lowStock'));
    }

}