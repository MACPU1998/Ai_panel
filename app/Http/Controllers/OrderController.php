<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderSubProduct;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SubProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{

    public function index(OrderDataTable $dataTable,Request $request)
    {
        if ($request->hasAny([
            'customer_id',
            'quantity',
            'total_price',
            'final_price',
            'label',
            'status',
        ])) {
            session(['order-filters' => $request->only([
                'customer_id',
                'quantity',
                'total_price',
                'final_price',
                'status',
            ])]);
        }

        $filters = session('order-filters', []);

        return $dataTable->render('admin.layouts.orders.manage_order', compact('filters'));
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
                        ->where('customer_id', $request->customer_id)
                        ->where('status', Order::STATUS_SHOPPING_CART);

                })
                ->groupBy('product_id')
                ->pluck('total_quantity', 'product_id')
                ->toArray();

        }

        return view('admin.layouts.orders.add_order', compact('customers', 'products', 'subProductQuantities'));
    }

    public function preview(Customer $customer)
    {
        $shippingCost = Setting::where('key', 'هزینه ارسال')->value('value') ?? 0;

        $previousOrderItems = OrderItem::whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->with('order')->orderByDesc('created_at')->get();

        $latestOrder = Order::where('customer_id', $customer->id)
            ->latest()
            ->first();

        $subProducts = $latestOrder
            ? OrderSubProduct::with('subProduct.product')->where('order_id', $latestOrder->id)->get()
            : collect();

        return view('admin.layouts.orders.preview', compact(
            'customer',
            'previousOrderItems',
            'shippingCost',
            'latestOrder',
            'subProducts'));
    }

    public function cartCount($customerId)
    {
        $order = Order::where('customer_id', $customerId)
            ->where('status', Order::STATUS_SHOPPING_CART)
            ->with('orderItems')
            ->first();

        $count = $order ? $order->orderItems->sum('quantity') : 0;
        //$count = $order ? $order->subProducts()->count() : 0;
        return response()->json(['count' => $count]);
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
                'product_name' => $productName,
                'total_price' => $productPrice * $request->quantity,
                'status' => OrderItem::STATUS_ACTIVE,
            ]);

        }
        $quantity = $request->quantity;

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
        $customerId = $request->input('customer_id');

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
        ]);

        $order = Order::where('customer_id', $customerId)
            ->where('status', Order::STATUS_SHOPPING_CART)
            ->with('orderItems')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $order->status = Order::STATUS_PAYMENT;

            $totalQuantity = 0;
            $totalPrice = 0;
            foreach ($order->orderItems as $item) {
                $totalQuantity += $item->quantity;
                $totalPrice += $item->price * $item->quantity;
            }
            $order->quantity = $totalQuantity;
            $order->total_price = $totalPrice;

            $shippingCost = Setting::where('key', 'هزینه ارسال')->value('value') ?? 0;
            $order->final_price = $totalPrice + $shippingCost;

            $order->save();

            // بروزرسانی هر آیتم سفارش و ذخیره ساب‌پروداکت‌ها
            foreach ($order->orderItems as $item) {
                $item->status = OrderItem::STATUS_PAYMENT;
                $item->save();

                $quantityToDeactivate = $item->quantity;

                $subProducts = SubProduct::where('product_id', $item->product_id)
                    ->where('status', SubProduct::STATUS_AVAILABLE)
                    ->orderByDesc('id')
                    ->take($quantityToDeactivate)
                    ->get();

                if ($subProducts->count() < $quantityToDeactivate) {
                    throw new \Exception("موجودی کافی برای محصول {$item->product_name} وجود ندارد.");
                }

                foreach ($subProducts as $subProduct) {
                    $subProduct->status = SubProduct::STATUS_INACTIVE;
                    $subProduct->save();

                    OrderSubProduct::create([
                        'order_id' => $order->id,
                        'sub_product_id' => $subProduct->id,
                        'barcode' => $subProduct->barcode,
                    ]);
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


    public function confirmLocal(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        DB::beginTransaction();
        try {
            $order->status = Order::STATUS_CONFIRMATION;;
            $order->save();

            foreach ($order->orderItems as $item) {
                $item->status = OrderItem::STATUS_SOLD_OUT;
                $item->save();
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'پرداخت با موفقیت ثبت شد و موجودی به‌روزرسانی شد.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('success', 'تایید ادمین با موفقیت انجام شد.');
        }
    }

//    public function invoice(Order $order)
//    {
//        $customer = $order->customer;
//        $orderItems = $order->orderItems()->with('product')->get();
//
//        $pdf = Pdf::loadView('admin.layouts.orders.invoice', compact('order', 'customer', 'orderItems'));
//
//        return $pdf->download("فاکتور-سفارش-{$order->id}.pdf");
//    }

    public function invoice(Order $order)
    {
        $customer = $order->customer;
        $orderItems = $order->orderItems()->with('product')->get();

        // محتوای HTML را از ویو بگیر
        $html = view('admin.layouts.orders.invoice', compact('order', 'customer', 'orderItems'))->render();

        // پیکربندی mpdf
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'vazir',
            'default_font_size' => 12,
            'tempDir' => storage_path('app/mpdf-temp') // برای ویندوز مهم است
        ]);

        // افزودن فونت فارسی سفارشی
        $fontDir = resource_path('fonts');
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

        $mpdf = new Mpdf([
            'tempDir' => storage_path('app/mpdf-temp'),
            'format' => 'A4',
            'mode' => 'utf-8',
            'fontDir' => array_merge($defaultConfig['fontDir'], [$fontDir]),
            'fontdata' => $defaultFontConfig['fontdata'] + [
                    'vazir' => [
                        'R' => 'Vazir-Regular.ttf',
                    ]
                ],
            'default_font' => 'vazir'
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        return response($mpdf->Output("فاکتور-سفارش-{$order->id}.pdf", 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    public function edit($id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        $products = Product::where('status', 1)->get();
        $subProductQuantities = [];
        foreach ($order->orderItems as $item) {
            $subProductQuantities[$item->product_id] = $item->quantity;
        }

        return view('admin.layouts.orders.edit_order', compact('order', 'products', 'subProductQuantities'));
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Order $order)
    {
        try {
            $order->orderItems()->delete();
            $order->subProducts()->detach();
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
