<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\Http\Requests\Customer\CustomerRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.customers.manage_customer');
    }

    public function create()
    {
        $country = Country::all();
        $state = State::all();
        $city = City::all();
        return view('admin.layouts.customers.add_customer', compact('country','state','city'));
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        if ($request->hasFile('image')) {
            $customer->addMediaFromRequest('image')->toMediaCollection('customer_images');
        }

        return redirect()->route('customers.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function getProductData()
    {
        $customer = Customer::query();

        return DataTables::of($customer)
            ->addColumn('action', function ($customer) {
                return '<a href="' . route('customers.edit', $customer->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(CustomerDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Customer $product)
    {
        $currencies = ProductCurrency::where('status', 1)->get();
        $product = Product::with('attributes')->find($product->id);
        $attributes = json_decode($product->attributes, true);

        return view('admin.layouts.products.edit_product', [
            'currencies' => $currencies,
            'product' => $product,
            'attributes' => $attributes,
            'image_url' => $product->getFirstMediaUrl('product_images')

        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        // بررسی و تبدیل رشته JSON به آرایه
        $attributes = json_decode($request->input('attributes'), true);

        // به‌روزرسانی اطلاعات محصول
        $product->update($request->validated());
        // حذف تصویر قبلی و آپلود جدید
        if ($request->hasFile('image')) {
            if ($product->hasMedia('product_images')) {
                $product->clearMediaCollection('product_images');
            }
            $product->addMediaFromRequest('image')->toMediaCollection('product_images');
        }

        // حذف ویژگی‌های قبلی
        $product->attributes()->delete();

        // ذخیره ویژگی‌های جدید
        if (is_array($attributes)) {
            foreach ($attributes as $attribute) {
                $product->attributes()->create([
                    'name' => $attribute['name'],
                    'value' => $attribute['value'],
                    'status' => 1,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    public function destroy(Product $product)
    {

        try {
            $product->clearMediaCollection('product_images');
            $product->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف محصول'], 500);
        }
    }

}
