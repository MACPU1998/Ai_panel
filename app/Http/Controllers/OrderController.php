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
    public function showPreview($orderId)
    {
        $order = Order::with('customer')->findOrFail($orderId);
        $orderItems = OrderItem::with('subProduct')->where('order_id', $orderId)->get();
        $total_price = $orderItems->sum('total_price');

        return view('admin.layouts.orders.preview', [
            'orderItems' => $orderItems,
            'customer' => $order->customer,
            'total_price' => $total_price,
        ]);
    }

    public function create(Request $request)
    {
        $customers = Customer::all();
        $products = Product::where('status', Product::STATUS_ACTIVE)
            ->whereHas('activeSubProducts')
            ->withCount(['activeSubProducts as active_sub_product_count'])
            ->with(['media', 'activeSubProducts'])
            ->get();

        $subProductQuantities = [];

        if ($request->customer_id) {
            $subProductQuantities = DB::table('order_items')
                ->select('sub_product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->whereIn('order_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from('orders')
                        ->where('customer_id', $request->customer_id);
                })
                ->groupBy('sub_product_id')
                ->pluck('total_quantity', 'sub_product_id')
                ->toArray();
        }

        return view('admin.layouts.orders.add_order', compact('customers', 'products', 'subProductQuantities'));
    }
    public function preview(Customer $customer, Request $request)
    {
        $previousOrderItems = OrderItem::whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->with('order')->orderByDesc('created_at')->get();

        return view('admin.layouts.orders.preview', compact('customer', 'previousOrderItems'));
    }


    public function addToOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sub_product_id' => 'required|exists:sub_products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => Order::STATUS_SHOPPING_CART],
            ['total_price' => 0, 'final_price' => 0, 'quantity' => 0, 'shipping_price' => 0, 'tax_price' => 0]
        );

        $subProduct = SubProduct::findOrFail($request->sub_product_id);
        $productPrice = $subProduct->product->price ?? 0;
        $productName = $subProduct->product->name ?? "0";

        $existingItem = $order->orderItems()->where('sub_product_id', $request->sub_product_id)->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->price = $productPrice; // قیمت به روز شود اگر لازم است
            $existingItem->save();
        } else {
            $order->orderItems()->create([
                'sub_product_id' => $request->sub_product_id,
                'quantity' => $request->quantity,
                'price' => $productPrice,
                'product_name'=>$productName,
                'total_price' => $productPrice * $request->quantity,
                'status' => OrderItem::STATUS_ACTIVE,
            ]);

        }

        // بروزرسانی مجموع تعداد و مبلغ کل سفارش
        $totalQuantity = $order->orderItems()->sum('quantity');
        $totalPrice = $order->orderItems()->sum(\DB::raw('price * quantity'));

        $order->quantity = $totalQuantity;
        $order->total_price = $totalPrice;
        $order->final_price = $totalPrice; // اگر مالیات یا هزینه ارسال داری اینجا اضافه کن
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
