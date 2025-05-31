<?php

namespace App\Http\Controllers;

use App\DataTables\SubProductDataTable;
use App\Http\Requests\SubProduct\SubProductGroupRequest;
use App\Http\Requests\SubProduct\SubProductRequest;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables;

class SubProductController extends Controller
{

    public function getProductInfo($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'serial_prefix' => $product->serial_prefix,
            'price' => $product->price,
            'final_price' => $product->final_price,
        ]);
    }

    public function index(SubProductDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.sub_products.manage_sub_product');
    }

    public function create()
    {
        $products = Product::where('status', 1)->get(['id', 'name', 'serial_prefix']);
        $warehouses = Warehouse::where('status', 1)->get();
        return view('admin.layouts.sub_products.add_sub_product', compact('products', 'warehouses'));
    }

    public function createGroup()
    {
        $products = Product::where('status', 1)->get(['id', 'name', 'serial_prefix']);
        return view('admin.layouts.sub_products.add_sub_product_group', compact('products'));
    }

    public function store(SubProductRequest $request)
    {
        $validated = $request->validated();
        $finalBarcode = trim($validated['serial_prefix']) . trim($validated['barcode']);
        unset($validated['serial_prefix']);
        $validated['barcode'] = $finalBarcode;
        SubProduct::create($validated);
        return redirect()->route('subProducts.index')->with('success', 'زیر محصول با موفقیت ایجاد شد.');
    }

    public function storeGroup(SubProductGroupRequest $request)
    {
        $data = $request->validated();

        $count = $data['count'] ?? 1;
        $serial_prefix = $data['serial_prefix'] ?? '';
        $barcode = $data['barcode'];
        $serieYear = $data['serie_year'];
        $serieMonth = $data['serie_month'];

        $base = $serial_prefix .$barcode. $serieYear . $serieMonth;

        $lastNumber = SubProduct::where('barcode', 'like', $base . '%')
            ->count();

        for ($i = 1; $i <= $count; $i++) {
            $number = $lastNumber + $i;
            $barcode = $base . str_pad($number, STR_PAD_LEFT);

            $subProductData = $data;
            $subProductData['barcode'] = $barcode;
            unset($subProductData['count'], $subProductData['prefix']);

            SubProduct::create($subProductData);
        }

        return redirect()->route('subProducts.index')->with('success', "{$count} زیرمحصول با موفقیت ایجاد شد.");
    }

    public function getSubProductData()
    {
        $subProduct = SubProduct::query();

        return DataTables::of($subProduct)
            ->addColumn('action', function ($subProduct) {
                return '<a href="' . route('products.edit', $subProduct->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(SubProductDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(SubProduct $subProduct)
    {
        $products = Product::all();
        $warehouses = Warehouse::where('status', 1)->get();
        return view('admin.layouts.sub_products.edit_sub_product', compact('subProduct', 'products', 'warehouses'));
    }

    public function update(SubProductRequest $request, SubProduct $subProduct)
    {
        $subProduct->update($request->validated());
        return redirect()->route('subProducts.index')->with('success', 'زیرمحصول با موفقیت ویرایش شد.');
    }

    public function destroy(SubProduct $subProduct)
    {
        try {
            $subProduct->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف زیرمحصول'], 500);
        }
    }

}
