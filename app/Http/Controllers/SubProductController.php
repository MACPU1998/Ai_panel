<?php

namespace App\Http\Controllers;

use App\DataTables\SubProductDataTable;
use App\Http\Requests\SubProduct\SubProductGroupRequest;
use App\Http\Requests\SubProduct\SubProductRequest;
use App\Http\Requests\SubProduct\UpdateSubProductRequest;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

    public function index(SubProductDataTable $dataTable, Request $request)
    {
        $warehouses = Warehouse::all();

        if ($request->hasAny([
            'product_id',
            'barcode',
            'serie_year',
            'serie_month',
            'label',
            'warehouse_id',
            'status',
            'production_date',
            'expiration_date'
        ])) {
            session(['sub-product-filters' => $request->only([
                'product_id',
                'barcode',
                'serie_year',
                'serie_month',
                'label',
                'warehouse_id',
                'status',
                'production_date',
                'expiration_date'
            ])]);
        }

        $filters = session('sub-product-filters', []);

        return $dataTable->render('admin.layouts.sub_products.manage_sub_product', compact('warehouses', 'filters'));
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
        $warehouses = Warehouse::where('status', 1)->get();
        return view('admin.layouts.sub_products.add_sub_product_group', compact('products', 'warehouses'));
    }

    public function createExcel()
    {
        return view('admin.layouts.sub_products.add_sub_product_excel');

    }

    public function downloadSampleExcel()
    {
        $path = public_path('excel/sub_products_example.xlsx');
        return response()->download($path, 'نمونه_اکسل.xlsx');
    }

    public function store(SubProductRequest $request)
    {
        $validated = $request->validated();
        $finalBarcode = trim($validated['barcode']);
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
        $serieYear = $data['serie_year'];
        $serieMonth = $data['serie_month'];

        $base = $serial_prefix . $serieYear . $serieMonth;

        // پیدا کردن بزرگ‌ترین شماره‌ای که تاکنون برای این بارکد ساخته شده
        $lastBarcode = SubProduct::where('barcode', 'like', $base . '%')
            ->orderBy('barcode', 'desc')
            ->value('barcode');

        // استخراج عدد چهار رقمی آخر بارکد
        $lastNumber = 0;
        if ($lastBarcode) {
            $lastNumber = (int)substr($lastBarcode, -4); // فقط ۴ رقم آخر
        }

        if ($lastNumber + $count > 9999) {
            return redirect()->back()->withErrors(['count' => 'تعداد درخواستی از محدودیت عددی بارکد بیشتر است. لطفا تعداد کمتری وارد کنید']);
        }

        for ($i = 1; $i <= $count; $i++) {
            $number = $lastNumber + $i;
            $barcode = $base . str_pad($number, 4, '0', STR_PAD_LEFT);

            $subProductData = $data;
            $subProductData['barcode'] = $barcode;
            unset($subProductData['count'], $subProductData['prefix']);

            SubProduct::create($subProductData);
        }

        return redirect()->route('subProducts.index')->with('success', "{$count} زیرمحصول با موفقیت ایجاد شد.");
    }

//    public function storeExcel(Request $request)
//    {
//        $request->validate([
//            'import_file' => 'required|file|mimes:xlsx,xls',
//        ]);
//
//        $file = $request->file('import_file');
//        $spreadsheet = IOFactory::load($file->getPathname());
//        $sheet = $spreadsheet->getActiveSheet();
//        $rows = $sheet->toArray(null, true, true, true);
//
//        array_shift($rows);
//
//        $validRows = [];
//        $errors = [];
//
//        foreach ($rows as $index => $row) {
//            $rowIndex = $index + 1;
//
//            $productId = trim($row['A']);
//            $barcode = trim($row['B']);
//
//            // بررسی وجود محصول
//            if (!is_numeric($productId) || !Product::where('id', $productId)->exists()) {
//                $errors[] = "ردیف {$rowIndex}: شناسه محصول «{$productId}» معتبر نیست یا وجود ندارد.";
//                continue;
//            }
//
//            if (empty($barcode)) {
//                $errors[] = "ردیف {$rowIndex}: بارکد وارد نشده است.";
//                continue;
//            }
//
//            $data = [
//                'product_id' => $productId,
//                'barcode' => $barcode,
//                'status' => 0,
////                'warehouse'=> اوون انباری که پیفرض هست
//            ];
//
//            $validator = Validator::make($data, [
//                'product_id' => 'required|exists:products,id',
//                'barcode' => 'required|string|max:255|unique:sub_products,barcode',
//            ]);
//
//            if ($validator->fails()) {
//                $errors[] = "ردیف {$rowIndex}: " . implode(' - ', $validator->errors()->all());
//                continue;
//            }
//
//            $validRows[] = $data;
//        }
//
//        if (!empty($errors)) {
//            return back()->withErrors(['import_errors' => $errors]);
//        }
//
//        DB::beginTransaction();
//        try {
//            foreach ($validRows as $data) {
//                SubProduct::create($data);
//            }
//            DB::commit();
//            return redirect()->route('subProducts.index')->with('success', 'زیرمحصولات با موفقیت ثبت شدند.');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->withErrors(['import_errors' => ['خطا در ذخیره‌سازی داده‌ها: ' . $e->getMessage()]]);
//        }
//    }

    public function storeExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('import_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        array_shift($rows); // حذف هدر

        $validRows = [];
        $errors = [];

        // گرفتن ID انبار پیش‌فرض
        $defaultWarehouse = \App\Models\Warehouse::where('make_default', true)->first();
        $defaultWarehouseId = $defaultWarehouse ? $defaultWarehouse->id : null;

        foreach ($rows as $index => $row) {
            $rowIndex = $index + 1; // چون هدر حذف شده، شماره واقعی ردیف اکسل

            $productId = trim($row['A'] ?? '');
            $barcode = trim($row['B'] ?? '');
            $serieYear = trim($row['C'] ?? '');
            $serieMonth = trim($row['D'] ?? '');
            $label = trim($row['E'] ?? '');
            $productionDate = trim($row['F'] ?? '');
            $expirationDate = trim($row['G'] ?? '');
            $warehouseId = trim($row['H'] ?? '');

            // بررسی وجود محصول
            if (!is_numeric($productId) || !Product::where('id', $productId)->exists()) {
                $errors[] = "ردیف {$rowIndex}: شناسه محصول «{$productId}» معتبر نیست یا وجود ندارد.";
                continue;
            }

            if (empty($barcode)) {
                $errors[] = "ردیف {$rowIndex}: بارکد وارد نشده است.";
                continue;
            }

            // استفاده از انبار پیش‌فرض اگر ID ندادند
            if (empty($warehouseId)) {
                $warehouseId = $defaultWarehouseId;
            } else {
                // بررسی وجود انبار فقط اگر مقدار داده شده
                if (!Warehouse::where('id', $warehouseId)->exists()) {
                    $errors[] = "ردیف {$rowIndex}: انبار با شناسه «{$warehouseId}» وجود ندارد.";
                    continue;
                }
            }

            // تبدیل تاریخ‌ها
            foreach (['productionDate' => 'production_date', 'expirationDate' => 'expiration_date'] as $inputField => $dbField) {
                if (!empty($$inputField)) {
                    try {
                        if (is_numeric($$inputField)) {
                            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($$inputField);
                            $$dbField = $date->format('Y-m-d');
                        } else {
                            $$dbField = \Carbon\Carbon::parse($$inputField)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $errors[] = "ردیف {$rowIndex}: فرمت تاریخ معتبر نیست.";
                        continue 2; // می‌ره سراغ ردیف بعدی
                    }
                } else {
                    $$dbField = null;
                }
            }

            $data = [
                'product_id' => $productId,
                'barcode' => $barcode,
                'serie_year' => $serieYear ?: null,
                'serie_month' => $serieMonth ?: null,
                'label' => $label ?: null,
                'production_date' => $production_date ?? null,
                'expiration_date' => $expiration_date ?? null,
                'status' => 0,
                'warehouse_id' => $warehouseId,
            ];

            $validator = Validator::make($data, [
                'product_id' => 'required|exists:products,id',
                'barcode' => 'required|string|max:255|unique:sub_products,barcode',
                'warehouse_id' => 'nullable|exists:warehouses,id',
                'serie_year' => 'nullable|string|max:255',
                'serie_month' => 'nullable|string|max:255',
                'label' => 'nullable|string|max:255',
                'production_date' => 'nullable|date',
                'expiration_date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                $errors[] = "ردیف {$rowIndex}: " . implode(' - ', $validator->errors()->all());
                continue;
            }

            $validRows[] = $data;
        }

        if (!empty($errors)) {
            return back()->withErrors(['import_errors' => $errors]);
        }

        DB::beginTransaction();
        try {
            foreach ($validRows as $data) {
                SubProduct::create($data);
            }
            DB::commit();
            return redirect()->route('subProducts.index')->with('success', 'زیرمحصولات با موفقیت ثبت شدند.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['import_errors' => ['خطا در ذخیره‌سازی: ' . $e->getMessage()]]);
        }
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

    public function update(UpdateSubProductRequest $request, SubProduct $subProduct)
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
