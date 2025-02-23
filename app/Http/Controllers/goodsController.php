<?php

namespace App\Http\Controllers;

use App\DataTables\goodsDataTable;
use App\Models\Goods;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class goodsController extends Controller
{
    public function index(goodsDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.goods.manage_goods');
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.layouts.goods.add_goods', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'barcode' => 'required|integer',
            'serial_date' => 'string',
            'version' => 'string',
            'status' => 'required|integer',
        ]);
        Goods::create([
            'product_id' => $validated['product_id'],
            'barcode' => $validated['barcode'],
            'serial_date' => $validated['serial_date'],
            'version' => $validated['version'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('goods.index')->with('success', 'کاربر با موفقیت ایجاد شد.');

    }

    public function getGoodsData(Request $request)
    {
        $goods = Goods::query();

        return DataTables::of($goods)
            ->addColumn('action', function ($goods) {
                return '<a href="' . route('permissions.edit', $goods->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(goodsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Goods $goods)
    {
        $products = Product::all();
        return view('admin.layouts.goods.edit_goods', compact('goods', 'products'));
    }

    public function update(Request $request, Goods $goods)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'barcode' => 'required|integer',
            'serial_date' => 'string',
            'version' => 'string',
            'status' => 'required|integer',
        ]);
        $goods->update([
            'product_id' => $validated['product_id'],
            'barcode' => $validated['barcode'],
            'serial_date' => $validated['serial_date'],
            'version' => $validated['version'],
            'status' => $validated['status'],
        ]);
        return redirect()->route('goods.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function destroy(Goods $goods)
    {
        try {
            $goods->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف مجوز'], 500);
        }
    }

}
