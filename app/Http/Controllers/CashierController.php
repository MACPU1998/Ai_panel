<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    public function index()
    {
        return view('admin.layouts.cashier.cashier');
    }

    public function searchProducts(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $byBarcode = SubProduct::where('barcode', 'like', "%{$query}%")
            ->where('status', SubProduct::STATUS_AVAILABLE)
            ->with(['product.media'])
            ->get()
            ->map(function ($sp) {
                return [
                    'id' => $sp->product_id,
                    'sub_id' => $sp->id,
                    'name' => $sp->product->name ?? '-',
                    'barcode' => $sp->barcode,
                    'price' => $sp->product->price ?? 0,
                    'image' => $sp->product->getFirstMediaUrl('product_images') ?: null,
                    'stock' => SubProduct::where('product_id', $sp->product_id)
                        ->where('status', SubProduct::STATUS_AVAILABLE)
                        ->count(),
                    'match_type' => 'barcode',
                ];
            });

        $byName = Product::where('name', 'like', "%{$query}%")
            ->where('status', Product::STATUS_ACTIVE)
            ->whereHas('activeSubProducts')
            ->withCount(['activeSubProducts as stock'])
            ->with(['media', 'activeSubProducts' => fn($q) => $q->limit(1)])
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'sub_id' => $product->activeSubProducts->first()->id ?? null,
                    'name' => $product->name,
                    'barcode' => null,
                    'price' => $product->price,
                    'image' => $product->getFirstMediaUrl('product_images') ?: null,
                    'stock' => $product->stock,
                    'match_type' => 'name',
                ];
            });

        $merged = $byBarcode->concat($byName)
            ->unique('id')
            ->values();

        return response()->json($merged);
    }

    public function searchCustomers(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $customers = Customer::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(15)
            ->get(['id', 'first_name', 'last_name', 'phone']);

        return response()->json($customers);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $product = Product::with('activeSubProducts')->findOrFail($request->product_id);

        $availableCount = $product->activeSubProducts->count();
        if ($availableCount < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => "موجودی کافی نیست. موجودی فعلی: {$availableCount} عدد",
            ], 400);
        }


        $order = Order::firstOrCreate(
            ['customer_id' => $request->customer_id, 'status' => Order::STATUS_SHOPPING_CART],
            ['total_price' => 0, 'final_price' => 0, 'quantity' => 0, 'shipping_price' => 0, 'tax_price' => 0]
        );

        $firstSubProduct = $product->activeSubProducts->first();

        $existingItem = $order->orderItems()->where('sub_product_id', $firstSubProduct->id)->first();
        if ($existingItem) {
            $existingItem->quantity = $request->quantity;
            $existingItem->price = $product->price;
            $existingItem->total_price = $product->price * $request->quantity;
            $existingItem->save();
        } else {
            $order->orderItems()->create([
                'sub_product_id' => $firstSubProduct->id,
                'product_name' => $product->name,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'total_price' => $product->price * $request->quantity,
                'status' => OrderItem::STATUS_ACTIVE,
            ]);
        }

        $alreadyReserved = DB::table('order_sub_products')
            ->where('order_id', $order->id)
            ->whereIn('sub_product_id', $product->activeSubProducts->pluck('id'))
            ->pluck('sub_product_id')
            ->toArray();

        $toReserve = $product->activeSubProducts
            ->whereNotIn('id', $alreadyReserved)
            ->take($request->quantity);

        foreach ($toReserve as $sp) {
            DB::table('order_sub_products')->insertOrIgnore([
                'order_id' => $order->id,
                'sub_product_id' => $sp->id,
                'barcode' => $sp->barcode,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->recalcOrder($order);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'cart' => $this->buildCartData($order),
        ]);
    }


    public function updateCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'item_id' => 'required|exists:order_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $item = OrderItem::with('subProduct.product')->findOrFail($request->item_id);
        $order = Order::findOrFail($request->order_id);

        $stock = SubProduct::where('product_id', $item->subProduct->product_id)
            ->where('status', SubProduct::STATUS_AVAILABLE)
            ->count();

        if ($stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => "موجودی کافی نیست. موجودی: {$stock}",
            ], 400);
        }

        $item->quantity = $request->quantity;
        $item->total_price = $item->price * $request->quantity;
        $item->save();

        $this->recalcOrder($order);

        return response()->json([
            'success' => true,
            'cart' => $this->buildCartData($order),
        ]);
    }

    public function removeCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'item_id' => 'required|exists:order_items,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $item = OrderItem::findOrFail($request->item_id);
        $order = Order::findOrFail($request->order_id);

        DB::table('order_sub_products')
            ->where('order_id', $order->id)
            ->where('sub_product_id', $item->sub_product_id)
            ->delete();

        $item->delete();

        $this->recalcOrder($order);

        return response()->json([
            'success' => true,
            'cart' => $this->buildCartData($order),
        ]);
    }

    public function getCart($customerId)
    {
        $order = Order::where('customer_id', $customerId)
            ->where('status', Order::STATUS_SHOPPING_CART)
            ->with(['orderItems.subProduct.product'])
            ->first();

        if (!$order) {
            return response()->json(['success' => true, 'cart' => null]);
        }

        return response()->json([
            'success' => true,
            'cart' => $this->buildCartData($order),
        ]);
    }

    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:customers,phone',
        ], [
            'first_name.required' => 'نام الزامی است.',
            'last_name.required' => 'نام خانوادگی الزامی است.',
            'phone.required' => 'شماره تلفن الزامی است.',
            'phone.unique' => 'این شماره تلفن قبلاً ثبت شده است.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'customer' => [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
            ],
        ]);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,card,mixed',
            'cash_amount' => 'required_if:payment_method,mixed|nullable|numeric|min:0',
            'card_amount' => 'required_if:payment_method,mixed|nullable|numeric|min:0',
        ], [
            'payment_method.required' => 'روش پرداخت الزامی است.',
            'payment_method.in' => 'روش پرداخت نامعتبر است.',
            'cash_amount.required_if' => 'مبلغ نقدی الزامی است.',
            'card_amount.required_if' => 'مبلغ کارت الزامی است.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $order = Order::with('orderItems')->findOrFail($request->order_id);

        if ($order->orderItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'سبد خرید خالی است.'], 400);
        }

        if ($request->payment_method === 'mixed') {
            $total = $request->cash_amount + $request->card_amount;
            if (abs($total - $order->final_price) > 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'جمع مبلغ نقدی و کارت با مبلغ کل سفارش مطابقت ندارد.',
                ], 400);
            }
        }

        DB::transaction(function () use ($order, $request) {
            // ثبت اطلاعات پرداخت در یادداشت سفارش (یا فیلد اضافه در صورت نیاز)
            $order->status = Order::STATUS_PENDING;

            // ذخیره اطلاعات پرداخت در session یا بعداً در جدول جداگانه
            // در حال حاضر در یک فیلد JSON-like description نگهداری می‌شود
            $order->payment_method = $request->payment_method;

            if ($request->payment_method === 'mixed') {
                $order->cash_amount = $request->cash_amount;
                $order->card_amount = $request->card_amount;
            }

            $order->save();

            $subProductIds = DB::table('order_sub_products')
                ->where('order_id', $order->id)
                ->pluck('sub_product_id')
                ->toArray();

            SubProduct::whereIn('id', $subProductIds)
                ->update(['status' => SubProduct::STATUS_RETURNED]); // STATUS_RETURNED = فروخته‌شده / غیرموجود
        });

        return response()->json([
            'success' => true,
            'message' => 'سفارش با موفقیت ثبت شد.',
            'order_id' => $order->id,
            'receipt_url' => route('orders.preview', $order->customer_id),
        ]);
    }

    private function recalcOrder(Order $order): void
    {
        $order->refresh();
        $order->quantity = $order->orderItems()->sum('quantity');
        $order->total_price = $order->orderItems()->sum(DB::raw('price * quantity'));
        $order->final_price = $order->total_price;
        $order->save();
    }

    // Helper: ساخت آرایه cart برای ارسال به frontend
    private function buildCartData(Order $order): array
    {
        $order->load('orderItems.subProduct.product');

        return [
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'total_price' => $order->total_price,
            'final_price' => $order->final_price,
            'quantity' => $order->quantity,
            'items' => $order->orderItems->map(fn($item) => [
                'id' => $item->id,
                'product_name' => $item->product_name ?? $item->subProduct?->product?->name,
                'barcode' => $item->subProduct?->barcode,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->total_price,
                'stock' => SubProduct::where('product_id', $item->subProduct?->product_id)
                    ->where('status', SubProduct::STATUS_AVAILABLE)
                    ->count(),
            ])->values()->toArray(),
        ];
    }
}
