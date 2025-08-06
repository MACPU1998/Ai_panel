<?php

namespace App\Http\Controllers;

use App\DataTables\WarehouseDataTable;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Http\Requests\Warehouse\WarehouseRequest;
use App\Models\Order;
use App\Models\SubProduct;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
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

    public function show(Warehouse $warehouse)
    {
        $subProducts = $warehouse->subProducts()
            ->with('product')
            ->where('status',SubProduct::STATUS_AVAILABLE)
            ->paginate(20);

        return view('admin.layouts.warehouses.show_warehouse', compact('warehouse', 'subProducts'));
    }

    public function transferSubProducts(Request $request)
    {
        $request->validate([
            'sub_product_ids' => 'required|array',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        \App\Models\SubProduct::whereIn('id', $request->sub_product_ids)
            ->update(['warehouse_id' => $request->warehouse_id]);

        return redirect()->back()->with('success', 'زیرمحصولات با موفقیت منتقل شدند.');
    }

    public function warehouseExportPdf(Warehouse $warehouse)
    {
        $subProducts = $warehouse->subProducts()
            ->with('product')
            ->where('status', SubProduct::STATUS_AVAILABLE)
            ->get();

        $html = view('admin.layouts.warehouses.export_warehouse', compact('warehouse', 'subProducts'))->render();

        $fontDir = resource_path('fonts');
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();

        $mpdf = new Mpdf([
            'tempDir' => storage_path('app/mpdf-temp'),
            'format' => 'A4',
            'mode' => 'utf-8',
            'fontDir' => array_merge($defaultConfig['fontDir'], [$fontDir]),
            'fontdata' => $defaultFontConfig['fontdata'] + [
                    'vazir' => [
                        'R' => 'Vazir-Regular.ttf',
                    ]
                ],
            'default_font' => 'vazir',
        ]);

        // 👇 بسیار مهم برای درست چسبیدن حروف فارسی
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);

        return response($mpdf->Output("زیرمحصولات-انبار-{$warehouse->id}.pdf", 'S'))
            ->header('Content-Type', 'application/pdf');
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
        $data = $request->validated();

        if (!empty($data['make_default'])) {
            Warehouse::where('make_default', true)->update(['make_default' => false]);
        } else {
            if (!Warehouse::where('make_default', true)->exists()) {
                $data['make_default'] = true;
            }
        }

        Warehouse::create($data);

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
        $data = $request->validated();

        if (!empty($data['make_default'])) {
            Warehouse::where('id', '!=', $warehouse->id)
                ->where('make_default', true)
                ->update(['make_default' => false]);
        } else {
            $isLastDefault = $warehouse->make_default &&
                !Warehouse::where('id', '!=', $warehouse->id)
                    ->where('make_default', true)
                    ->exists();

            if ($isLastDefault) {
                return redirect()->back()
                    ->withErrors(['make_default' => 'حداقل یک انبار باید به عنوان پیش‌فرض باقی بماند.']);
            }
        }
        $warehouse->update($data);

        return redirect()->route('warehouses.index')->with('success', 'انبار با موفقیت بروزرسانی شد.');
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
