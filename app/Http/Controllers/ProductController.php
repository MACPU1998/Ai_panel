<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Models\Product;
use App\Models\ProductCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.products.manage_product');
    }

    public function create()
    {
        $currencies = ProductCurrency::where('status', 1)->get();
        return view('admin.layouts.products.add_product', compact('currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'nullable',
            'attributes' => 'nullable|string',
        ]);

        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        // ذخیره تصویر در storage/app/public/images/
        $imagePath = $request->file('image')->store('images', 'public');

        // ایجاد محصول در دیتابیس
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $imagePath,
            'currency_id' => $validated['currency_id'],
            'price' => $validated['price'],
            'final_price' => $validated['final_price'],
        ]);

        // ذخیره ویژگی‌ها
        if (is_array($attributes)) {
            foreach ($attributes as $attribute) {
                $product->attributes()->create([
                    'name' => $attribute['name'],
                    'value' => $attribute['value'],
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function getProductData(Request $request)
    {
        $product = Product::query();

        return DataTables::of($product)
            ->addColumn('action', function ($product) {
                return '<a href="' . route('products.edit', $product->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(ProductDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Product $product)
    {
        $currencies = ProductCurrency::where('status', 1)->get();
        $product = Product::with('attributes')->find($product->id);
        $attributes = json_decode($product->attributes, true);

        return view('admin.layouts.products.edit_product', [
            'currencies' => $currencies,
            'product' => $product,
            'attributes' => $attributes,
            'image_url' => asset('storage/' . $product->image)
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3|max:255',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // تغییر به nullable
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'nullable',
            'attributes' => 'nullable|string',
        ]);

        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        // بررسی اینکه آیا تصویر جدید آپلود شده است
        if ($request->hasFile('image')) {
            // حذف تصویر قبلی از storage
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            // ذخیره تصویر جدید در storage/app/public/images/
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath; // ذخیره مسیر در دیتابیس
        } else {
            // اگر تصویری جدید آپلود نشده باشد، مقدار قبلی را نگه می‌داریم
            $validated['image'] = $product->image;
        }

        // به‌روزرسانی اطلاعات محصول
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $validated['image'], // ذخیره مسیر صحیح تصویر
            'currency_id' => $validated['currency_id'],
            'price' => $validated['price'],
            'final_price' => $validated['final_price'],
        ]);

        // حذف ویژگی‌های قبلی
        $product->attributes()->delete();

        // ذخیره ویژگی‌های جدید
        if (is_array($attributes)) {
            foreach ($attributes as $attribute) {
                $product->attributes()->create([
                    'name' => $attribute['name'],
                    'value' => $attribute['value'],
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف محصول'], 500);
        }
    }
}
