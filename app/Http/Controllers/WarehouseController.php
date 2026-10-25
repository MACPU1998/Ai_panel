<?php

namespace App\Http\Controllers;

use App\DataTables\WarehousesDataTable;
use App\Http\Requests\Warehouse\WarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{

    public function datatable(WarehousesDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function index(WarehousesDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.warehouses.manage_warehouse');
    }

    public function create()
    {
        return view('admin.layouts.warehouses.add_warehouse');
    }

    public function store(WarehouseRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            if ((int) $data['status'] === 0) {
                $data['make_default'] = 0;
            }

            if ((int) $data['make_default'] === 1) {
                Warehouse::query()->update(['make_default' => 0]);
            }

            Warehouse::create($data);
        });

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'انبار با موفقیت ایجاد شد.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.layouts.warehouses.edit_warehouse', compact('warehouse'));
    }

    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $warehouse) {
            if ((int) $data['status'] === 0) {
                $data['make_default'] = 0;
            }

            if ((int) $data['make_default'] === 1) {
                Warehouse::where('id', '!=', $warehouse->id)
                    ->update(['make_default' => 0]);
            }

            $warehouse->update($data);
        });

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'انبار با موفقیت ویرایش شد.');
    }

    public function destroy(Warehouse $warehouse)
    {
        try {
            $warehouse->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف انباری'], 500);
        }
    }

}
