<?php

namespace App\Http\Controllers;

use App\DataTables\ProductAttributeDataTable;
use App\Http\Requests\ProductAttribute\ProductAttributeRequest;
use App\Http\Requests\ProductAttribute\UpdateProductAttributeRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductAttributeController extends Controller
{

    public function index(ProductAttributeDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.product_attributes.manage_product_attribute');
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.layouts.product_attributes.add_product_attribute', compact('products'));
    }


    public function store(ProductAttributeRequest $request)
    {
        ProductAttribute::create($request->validated());
        return redirect()->route('productAttributes.index')->with('success', 'ویژگی محصول با موفقیت ایجاد شد.');

    }

    public function getProductAttributeData(Request $request)
    {
        $productAttribute = ProductAttribute::query();

        return DataTables::of($productAttribute)
            ->addColumn('action', function ($productAttribute) {
                return '<a href="' . route('productAttributes.edit', $productAttribute->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(ProductAttributeDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(ProductAttribute $productAttribute)
    {
        $products = Product::where('status', 1)->get();
        return view('admin.layouts.product_attributes.edit_product_attribute',
            ['productAttribute' => $productAttribute, 'products' => $products]);
    }

    public function update(UpdateProductAttributeRequest $request, ProductAttribute $productAttribute)
    {
        $productAttribute->update($request->validated());
        return redirect()->route('productAttributes.index')->with('success', 'ویژگی محصول با موفقیت ویرایش شد.');
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        try {
            $productAttribute->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف ویژگی محصول'], 500);
        }
    }
}
