<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Models\ProductCurrency;
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
        $currencies = ProductCurrency::where('status', 1)->get();
        return view('admin.layouts.products.add_product', compact('currencies'));
    }

    public function store(ProductRequest $request)
    {
        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        $product = Product::create($request->validated());

        // ذخیره تصویر با Spatie Media Library
        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('product_images');
        }

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
            'image_url' => $product->getFirstMediaUrl('product_images')

        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        // به‌روزرسانی اطلاعات محصول
        $product->update($request->validated());
        // حذف تصویر قبلی و آپلود جدید
        if ($request->hasFile('image')) {
            if ($product->hasMedia('product_images')) {
                $product->clearMediaCollection('product_images');
            }
            $product->addMediaFromRequest('image')->toMediaCollection('product_images');
        }

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
            $product->clearMediaCollection('product_images');
            $product->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف محصول'], 500);
        }
    }

}
