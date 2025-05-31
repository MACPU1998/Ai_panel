<?php

namespace App\Http\Controllers;

use App\DataTables\WarehouseDataTable;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Http\Requests\Warehouse\WarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WarehouseDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.warehouses.manage_warehouse');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layouts.warehouses.add_warehouse');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WarehouseRequest $request)
    {
        Warehouse::create($request->validated());
        return redirect()->route('warehouses.index')->with('success', 'انبار با موفقیت ایجاد شد.');

    }

    public function getWarehousesData(Request $request)
    {
        $warehouse = Warehouse::query();

        return DataTables::of($warehouse)
            ->addColumn('action', function ($warehouse) {
                return '<a href="' . route('warehouses.edit', $warehouse->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(WarehouseDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {

        return view('admin.layouts.warehouses.edit_warehouse', ['warehouse' => $warehouse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());
        return redirect()->route('warehouses.index')->with('success', 'انبار با موفقیت ویرایش شد.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        try {
            $warehouse->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف انبار'], 500);
        }
    }
}
