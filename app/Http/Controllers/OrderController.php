<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{

    public function index(OrderDataTable $dataTable )
    {
        return $dataTable->render('admin.layouts.orders.manage_order');
    }


    public function create()
    {
        $customers=Customer::all();
        $products = Product::where('status', Product::STATUS_ACTIVE)
            ->whereHas('activeSubProducts')
            ->withCount([
                'activeSubProducts as active_sub_product_count'
            ])
            ->with('media')
            ->get();

        return view('admin.layouts.orders.add_order', compact('customers', 'products'));
    }

    public function preview(Customer $customer, Request $request)
    {
        $product_quantities = $request->input('product_quantities', []);
        $total_items = array_sum($product_quantities);

        session(['cart_count' => $total_items]); // اختیاری برای نمایش در آیکن سبد خرید

        $products = Product::whereIn('id', array_keys($product_quantities))->get();

        $total_price = 0;
        foreach ($products as $product) {
            $quantity = $product_quantities[$product->id] ?? 0;
            $total_price += $product->price * $quantity;
        }

        return view('admin.layouts.orders.preview', compact(
            'customer', 'products', 'product_quantities', 'total_price'
        ));
    }

//    public function cartCount(Customer $customer)
//    {
//        $order = Order::where('customer_id', $customer->id)
//            ->where('status', 1)
//            ->first();
//
//        $count = $order ? $order->orderItems()->sum('quantity') : 0;
//
//        return response()->json(['count' => $count]);
//    }

    public function addToOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'ub_producst_id' => 'required|exists:sub_products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => Order::STATUS_PROCESSING],
            ['total_price' => 0, 'final_price' => 0, 'quantity' => 0, 'shipping_price' => 0, 'tax_price' => 0]
        );

        $subProduct = SubProduct::findOrFail($request->sub_product_id);
        $productPrice = $subProduct->product->price ?? 0;

        $existingItem = $order->orderItems()->where('sub_product_id', $request->sub_product_id)->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->price = $productPrice;
            $existingItem->save();
        } else {
            $order->orderItems()->create([
                'sub_product_id' => $request->sub_product_id,
                'quantity' => $request->quantity,
                'price' => $productPrice,
                'status' => OrderItem::STATUS_PENDING,
            ]);
        }

        // بروزرسانی مجموع تعداد و مبلغ کل سفارش
        $totalQuantity = $order->orderItems()->sum('quantity');
        $totalPrice = $order->orderItems()->sum(\DB::raw('price * quantity'));

        $order->quantity = $totalQuantity;
        $order->total_price = $totalPrice;
        $order->final_price = $totalPrice;
        $order->save();

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }


    public function store(Request $request)
    {

      //  session()->forget('cart_count');

    }



    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف زیرمحصول'], 500);
        }
    }

    public function getOrdersData()
    {
        $customer = Order::query();

        return DataTables::of($customer)
            ->addColumn('action', function ($order) {
                return '<a href="' . route('orders.edit', $order->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(OrderDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
