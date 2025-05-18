<?php

namespace App\Http\Controllers;

use App\DataTables\SubProductDataTable;
use App\Http\Requests\SubProduct\SubProductGroupRequest;
use App\Http\Requests\SubProduct\SubProductRequest;
use App\Models\Product;
use App\Models\SubProduct;
use Yajra\DataTables\DataTables;

class SubProductController extends Controller
{

    public function index(SubProductDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.sub_products.manage_sub_product');
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.layouts.sub_products.add_sub_product', compact('products'));
    }

    public function createGroup()
    {
        $products = Product::where('status', 1)->get();
        return view('admin.layouts.sub_products.add_sub_product_group', compact('products'));
    }

    public function store(SubProductRequest $request)
    {
        SubProduct::create($request->validated());
        return redirect()->route('subProducts.index')->with('success', 'زیر محصول با موفقیت ایجاد شد.');
    }

    public function storeGroup(SubProductGroupRequest $request)
    {
        $data = $request->validated();

        $count = $data['count'] ?? 1;
        $prefix = $data['prefix'] ?? '';
        $serieYear = $data['serie_year'];
        $serieMonth = $data['serie_month'];

        $base = $prefix . $serieYear . $serieMonth;

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
        return view('admin.layouts.sub_products.edit_sub_product', compact('subProduct', 'products'));
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
