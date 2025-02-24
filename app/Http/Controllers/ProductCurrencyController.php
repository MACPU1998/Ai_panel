<?php

namespace App\Http\Controllers;

use App\DataTables\ProductCurrencyDataTable;
use App\Http\Requests\ProductCurrencyRequest;
use App\Models\ProductCurrency;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCurrencyController extends Controller
{

    public function index(ProductCurrencyDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.product_currencies.manage_product_currency');
    }

    public function create()
    {
        return view('admin.layouts.product_currencies.add_product_currency');
    }


    public function store(ProductCurrencyRequest $request)
    {
        ProductCurrency::create($request->validated());
        return redirect()->route('productCurrencies.index')->with('success', 'ارز با موفقیت ایجاد شد.');

    }

    public function getProductCurrencyData(Request $request)
    {
        $productCurrency = ProductCurrency::query();

        return DataTables::of($productCurrency)
            ->addColumn('action', function ($productCurrency) {
                return '<a href="' . route('productCurrencies.edit', $productCurrency->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(ProductCurrencyDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(ProductCurrency $productCurrency)
    {

        return view('admin.layouts.product_currencies.edit_product_currency', ['productCurrency' => $productCurrency]);
    }

    public function update(Request $request, ProductCurrency  $productCurrency)
    {
        $productCurrency->update($request->validated());
        return redirect()->route('productCurrencies.index')->with('success', 'ارز با موفقیت ویرایش شد.');
    }

    public function destroy(ProductCurrency $productCurrency)
    {
        try {
            $productCurrency->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف ارز'], 500);
        }
    }
}
