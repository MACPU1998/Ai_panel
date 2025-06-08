<?php

namespace App\Http\Controllers;

use App\DataTables\SubProductDataTable;
use App\Http\Requests\SubProduct\SubProductGroupRequest;
use App\Http\Requests\SubProduct\SubProductRequest;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;
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
        $warehouses = Warehouse::where('status', 1)->get();
        return view('admin.layouts.sub_products.add_sub_product_group', compact('products','warehouses'));
    }

    public function createExcel()
    {
        return view('admin.layouts.sub_products.add_sub_product_excel');

    }

    public function downloadSampleExcel()
    {
        $path = public_path('samples/sub_products_sample.xlsx');
        return response()->download($path, 'نمونه_اکسل.xlsx');
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


    public function storeExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('import_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // حذف ردیف اول (هدرها)
        array_shift($rows);

        $errors = [];
        $validRows = [];

        foreach ($rows as $index => $row) {
            $rowIndex = $index + 2; // چون ردیف اول هدره، از 2 شروع میشه

            // فرض: A=product_id یا نام محصول، B=barcode, C=serie_year, D=serie_month, E=label, F=production_date, G=expiration_date, H=status, I=warehouse_id
            $data = [
                'product_id'       => trim($row['A']),
                'barcode'          => trim($row['B']),
                'serie_year'       => trim($row['C']),
                'serie_month'      => trim($row['D']),
                'label'            => trim($row['E']),
                'production_date'  => trim($row['F']),
                'expiration_date'  => trim($row['G']),
                'status'           => trim($row['H']),
                'warehouse_id'     => trim($row['I']),
            ];

            if (!is_numeric($data['product_id'])) {
                $product = Product::where('name', $data['product_id'])->first();
                if ($product) {
                    $data['product_id'] = $product->id;
                } else {
                    $errors[] = "ردیف {$rowIndex}: محصول با نام «{$data['product_id']}» یافت نشد.";
                    continue;
                }
            }

            if (!is_numeric($data['warehouse_id'])) {
                $warehouse= Warehouse::where('name', $data['warehouse_id'])->first();
                if ($warehouse) {
                    $data['warehouse_id'] = $warehouse->id;
                } else {
                    $errors[] = "ردیف {$rowIndex}: انبار با نام «{$data['warehouse_id']}» یافت نشد.";
                    continue;
                }
            }

            $statusMap = [
                'غیر فعال' => 0,
                'فعال' => 1,
                'مرجوعی' => 2,
            ];

            $statusFa = $data['status'];
            if (isset($statusMap[$statusFa])) {
                $data['status'] = $statusMap[$statusFa];
            } else {
                $errors[] = "ردیف {$rowIndex}: مقدار وضعیت «{$statusFa}» نامعتبر است.";
                continue;
            }

//            // تبدیل تاریخ شمسی به میلادی و فرمت مناسب timestamp دیتابیس
//            try {
//                if (!empty($data['production_date'])) {
//                    $carbonDate =Jalalian::fromFormat('Y/m/d', $data['production_date'])->toCarbon();
//                    $data['production_date'] = $carbonDate->format('Y-m-d H:i:s');
//                } else {
//                    $data['production_date'] = null;
//                }
//                if (!empty($data['expiration_date'])) {
//                    $carbonDate =Jalalian::fromFormat('Y/m/d', $data['expiration_date'])->toCarbon();
//                    $data['expiration_date'] = $carbonDate->format('Y-m-d H:i:s');
//                } else {
//                    $data['expiration_date'] = null;
//                }
//            } catch (\Exception $e) {
//                $errors[] = "ردیف {$rowIndex}: فرمت تاریخ تولید یا انقضا صحیح نیست (باید به صورت 1403/03/01 باشد).";
//                continue;
//            }



            // اعتبارسنجی
            $validator = Validator::make($data, [
                'product_id'      => 'required|exists:products,id',
                'barcode'         => 'required|string|max:255',
                'serie_year'      => 'nullable|string',
                'serie_month'     => 'nullable|string',
                'label'           => 'nullable|string|max:255',
                'production_date' => 'nullable|date',
                'expiration_date' => 'nullable|date',
                'status'          => 'required|in:0,1,2',
                'warehouse_id'    => 'nullable|exists:warehouses,id',
            ]);

            if ($validator->fails()) {
                $errors[] = "ردیف {$rowIndex}: " . implode(' - ', $validator->errors()->all());
                continue;
            }

            $validRows[] = $data;
        }

        // اگر خطایی وجود داشت، نمایش به کاربر
        if (!empty($errors)) {
            return back()->withErrors(['import_errors' => $errors]);
        }

        // ذخیره اطلاعات در جدول
        foreach ($validRows as $data) {
            SubProduct::create($data);
        }

        return redirect()->route('subProducts.index')->with('success', 'زیرمحصولات با موفقیت ایمپورت شدند.');
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
