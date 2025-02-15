<?php

namespace App\Http\Controllers;

use App\DataTables\ProductAttributeDataTable;
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
        return view('admin.layouts.product_attributes.add_product_attribute');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'value' => 'required|string',
            'status' => 'required',
            'product_id' => 'required',
        ]);
        ProductAttribute::create([
            'name' => $validated['name'],
            'value' => $validated['value'],
            'status' => $validated['status'],
            'product_id' => $validated['product_id'],
        ]);
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

        return view('admin.layouts.product_attributes.edit_product_attribute', ['productAttribute' => $productAttribute]);
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'value' => 'required|string',
            'status' => 'required',
            'product_id' => 'required',
        ]);
        $productAttribute->update([
            'name' => $validated['name'],
            'value' => $validated['value'],
            'status' => $validated['status'],
            'product_id' => $validated['product_id'],
        ]);
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
