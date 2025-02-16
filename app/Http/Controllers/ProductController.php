<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.products.manage_product');
    }

    public function create()
    {
        return view('admin.layouts.products.add_product');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'string|min:3|nullable',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'nullable',

            'attributes' => 'nullable|string', // بررسی نوع داده‌ها
        ]);

        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $validated['image'],
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
        $product = Product::with('attributes')->find($product->id);
        $attributes = json_decode($product->attributes, true);

        return view('admin.layouts.products.edit_product', [
            'product' => $product,
            'attributes' => $attributes,
            'image_url' => asset('storage/' . $product->image) // مسیر تصویر را ارسال می‌کنیم
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'string|min:3|max:255|nullable',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'nullable',

            'attributes' => 'nullable|string',
        ]);

        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $validated['image'],
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
