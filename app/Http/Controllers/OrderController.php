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
                ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->whereIn('order_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from('orders')
                        ->where('customer_id', $request->customer_id);
                })
                ->groupBy('product_id')
                ->pluck('total_quantity', 'product_id')
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
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        $order = Order::firstOrCreate(
            ['customer_id' => $customer->id, 'status' => Order::STATUS_SHOPPING_CART],
            ['total_price' => 0, 'final_price' => 0, 'quantity' => 0, 'shipping_price' => 0, 'tax_price' => 0]
        );

        $product = Product::findOrFail($request->product_id);
        $productPrice = $product->final_price ?? $product->price ?? 0;
        $productName = $product->name ?? "بدون نام";

//        $existingItem = $order->orderItems()->where('sub_product_id', $request->sub_product_id)->first();
        $existingItem = $order->orderItems()->where('product_id', $request->product_id)->first();

        if ($existingItem) {
            $existingItem->quantity = $request->quantity;
            $existingItem->price = $productPrice;
            $existingItem->total_price = $productPrice * $request->quantity;
            $existingItem->save();
        } else {
            $order->orderItems()->create([

                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $productPrice,
                'product_name'=>$productName,
                'total_price' => $productPrice * $request->quantity,
                'status' => OrderItem::STATUS_ACTIVE,
            ]);

        }
        $quantity = $request->quantity;

        // به‌روزرسانی مقادیر کلی سفارش
        $totalQuantity = $order->orderItems()->sum('quantity');
        $totalPrice = $order->orderItems()->sum(\DB::raw('price * quantity'));


        $order->quantity = $totalQuantity;
        $order->total_price = $totalPrice;
        $order->final_price = $totalPrice; // اگر مالیات یا هزینه ارسال داری اینجا اضافه کن
        $order->save();

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }


    public function store(Request $request, )
    {
        $customerId = $request->input('customer_id');

        $request->validate([
            'shipping_method' => 'required|integer|min:0',
            // احتمالا داده‌های دیگه‌ای لازم باشه ولی با توجه به مثال همین کافیه
        ]);

        // فرض کنیم سفارش (Order) موجود و در حالت سبد خرید است
        $order = Order::where('customer_id', $customerId)
            ->where('status', Order::STATUS_SHOPPING_CART)
            ->with('orderItems')
            ->firstOrFail();

        // شروع تراکنش برای جلوگیری از مشکل همزمانی
        DB::beginTransaction();

        try {
            // 1- بروزرسانی وضعیت سفارش و روش ارسال
            $order->shipping_price = $request->shipping_method;
            $order->status = Order::STATUS_PAYMENT;

            // جمع تعداد و قیمت کل سفارش از orderItems
            $totalQuantity = 0;
            $totalPrice = 0;
            foreach ($order->orderItems as $item) {
                $totalQuantity += $item->quantity;
                $totalPrice += $item->price * $item->quantity;
            }
            $order->quantity = $totalQuantity;
            $order->total_price = $totalPrice;
            $order->final_price = $totalPrice + $order->shipping_price;

            $order->save();

            // 2- برای هر آیتم سفارش، بروزرسانی وضعیت OrderItem و کم کردن موجودی SubProduct
            foreach ($order->orderItems as $item) {
                // تغییر وضعیت آیتم به پرداخت شده
                $item->status = OrderItem::STATUS_PAYMENT;
                $item->save();

                // کم کردن موجودی در SubProduct ها برای این محصول
                $quantityToDeactivate = $item->quantity;

                // انتخاب ساب‌پروداکت های موجود از آخر به اول که مرتبط با محصول و فعال هستند
                $subProducts = SubProduct::where('product_id', $item->product_id)
                    ->where('status', SubProduct::STATUS_AVAILABLE)
                    ->orderByDesc('id')
                    ->take($quantityToDeactivate)
                    ->get();

                if ($subProducts->count() < $quantityToDeactivate) {
                    // اگر موجودی کافی نیست، خطا بزنیم
                    throw new \Exception("موجودی کافی برای محصول {$item->product_name} وجود ندارد.");
                }

                // تغییر وضعیت SubProduct ها به غیر فعال
                foreach ($subProducts as $subProduct) {
                    $subProduct->status = SubProduct::STATUS_INACTIVE;
                    $subProduct->save();
                }
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'پرداخت با موفقیت ثبت شد و موجودی به‌روزرسانی شد.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
            // حذف آیتم‌ها
            $order->orderItems()->delete();

            // قطع ارتباط با sub products
            $order->subProducts()->detach();

            // حذف خود سفارش
            $order->delete();

            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            \Log::error('خطا در حذف سفارش: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'خطا در حذف سفارش'], 500);
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
