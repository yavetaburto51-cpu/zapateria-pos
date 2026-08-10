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
        $products = Product::select('id', 'model', 'sale_price', 'stock')
            ->where('stock', '>', 0)
            ->orderBy('model', 'asc')
            ->get();
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
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);

            // Validar stock
            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Producto no disponible (sin Stock)');
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
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Producto no disponible (sin Stock)');
        }
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
                    throw new \Exception("Producto no disponible (Sin stock)");
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

            session()->forget('cart');

            return redirect()->back()->with(['success' => 'Venta completada', 'sale_id' => $sale->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function history()
    {
        $sales = Sale::with('details.product', 'user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

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
            ->limit(50)
            ->get();

        // Indicadores del día
        $today = Carbon::today();
        $startOfDay = $today->copy()->startOfDay();
        $endOfDay = $today->copy()->endOfDay();

        $salesTodayStats = Sale::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->select(
                DB::raw('COALESCE(SUM(total), 0) as total_today'),
                DB::raw('COUNT(*) as count_today')
            )
            ->first();

        $totalToday = (float) ($salesTodayStats->total_today ?? 0);
        $countToday = (int) ($salesTodayStats->count_today ?? 0);
        $averageToday = $countToday > 0 ? $totalToday / $countToday : 0;

        // Ventas semanales (últimos 7 días) agrupadas en 1 sola consulta
        $startDate = Carbon::today()->subDays(6)->startOfDay();

        $dailyTotals = Sale::whereBetween('created_at', [$startDate, $endOfDay])
            ->select(
                DB::raw('DATE(created_at) as sale_date'),
                DB::raw('SUM(total) as daily_total')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get()
            ->mapWithKeys(function ($item) {
                $dateKey = Carbon::parse($item->sale_date)->format('Y-m-d');
                return [$dateKey => (float) $item->daily_total];
            });

        $weeklySales = [];
        $weeklyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $weeklySales[] = (float) ($dailyTotals[$dateStr] ?? 0);
            $weeklyLabels[] = $date->format('d/m');
        }

        // Stock bajo
        $lowStock = Product::select('id', 'model', 'stock')
            ->where('stock', '<', 5)
            ->limit(50)
            ->get();

        return view('reports.top-products', compact('products', 'totalToday', 'countToday', 'averageToday', 'weeklySales', 'weeklyLabels', 'lowStock'));
    }

    public function dailyReport()
    {
        $today = Carbon::today();
        $startOfDay = $today->copy()->startOfDay();
        $endOfDay = $today->copy()->endOfDay();

        $salesStats = Sale::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->select(
                DB::raw('COALESCE(SUM(total), 0) as total_sum'),
                DB::raw('COUNT(*) as total_count')
            )
            ->first();

        $total = (float) ($salesStats->total_sum ?? 0);
        $count = (int) ($salesStats->total_count ?? 0);
        $average = $count > 0 ? $total / $count : 0;

        $sales = Sale::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('reports.daily', compact('sales', 'total', 'count', 'average'));
    }

    public function dashboard()
    {
        $lowStock = Product::select('id', 'model', 'stock')
            ->where('stock', '<', 5)
            ->limit(20)
            ->get();

        $today = Carbon::today();
        $weekStart = $today->copy()->subDays(6)->startOfDay();
        $weekEnd = $today->copy()->endOfDay();

        $weeklySalesCount = Sale::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $weeklySalesTotal = Sale::whereBetween('created_at', [$weekStart, $weekEnd])->sum('total');

        if (auth()->user()->isEmployee()) {
            $employeeSales = Sale::where('user_id', auth()->id())
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->select(
                    DB::raw('COUNT(*) as sales_count'),
                    DB::raw('SUM(total) as sales_total')
                )
                ->first();

            $employeeSaleRecords = Sale::with('details.product')
                ->where('user_id', auth()->id())
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->orderByDesc('created_at')
                ->get();
        } else {
            $employeeSales = Sale::join('users', 'sales.user_id', '=', 'users.id')
                ->whereBetween('sales.created_at', [$weekStart, $weekEnd])
                ->select(
                    'users.id',
                    'users.name',
                    DB::raw('COUNT(sales.id) as sales_count'),
                    DB::raw('SUM(sales.total) as sales_total')
                )
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('sales_total')
                ->get();

            $employeeSaleRecords = collect();
        }

        return view(
            'dashboard',
            compact('lowStock', 'weeklySalesCount', 'weeklySalesTotal', 'employeeSales', 'employeeSaleRecords')
        );
    }

}