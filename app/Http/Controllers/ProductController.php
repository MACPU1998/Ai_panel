<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Models\Product;
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
            'description' => 'required|string|min:3|nullable',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'required',
        ]);
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $validated['image'],
            'currency_id' => $validated['currency_id'],
            'price' => $validated['price'],
            'final_price' => $validated['final_price'],
        ]);
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

        return view('admin.layouts.products.edit_product', ['product' => $product]);
    }

    public function update(Request $request, Product  $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:255|nullable',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'currency_id' => 'required',
            'price' => 'required',
            'final_price' => 'required',
        ]);
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $validated['image'],
            'currency_id' => $validated['currency_id'],
            'price' => $validated['price'],
            'final_price' => $validated['final_price'],
        ]);
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
