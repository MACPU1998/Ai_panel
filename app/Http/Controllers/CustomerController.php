<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\Http\Requests\Customer\CustomerRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{

    public function index(CustomerDataTable $dataTable,Request $request)
    {
        if ($request->hasAny([
            'first_name',
            'last_name',
            'phone',
            'national_id',
            'birth_date',
            'country_id',
            'state_id',
            'city_id',
        ])) {
            session(['customer-filters' => $request->only([
                'first_name',
                'last_name',
                'phone',
                'national_id',
                'birth_date',
                'country_id',
                'state_id',
                'city_id'
            ])]);
        }
        $filters = session('customer-filters', []);

        return $dataTable->render('admin.layouts.customers.manage_customer', compact('filters'));
    }

    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('admin.layouts.customers.add_customer', compact('countries','states','cities'));
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        if ($request->hasFile('image')) {
            $customer->addMediaFromRequest('image')->toMediaCollection('customer_images');
        }

        $wallet = Wallet::create([
            'customer_id' => $customer->id,
            'balance' => 0,
        ]);

        $customer->update([
            'wallet_id' => $wallet->id,
        ]);

        return redirect()->route('customers.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function getCustomersData()
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

    public function edit(Customer $customer)
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('admin.layouts.customers.edit_customer', [
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'customer' => $customer,
            'image_url' => $customer->getFirstMediaUrl('customer_images')

        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        // حذف تصویر قبلی و آپلود جدید
        if ($request->hasFile('image')) {
            if ($customer->hasMedia('customer_images')) {
                $customer->clearMediaCollection('customer_images');
            }
            $customer->addMediaFromRequest('image')->toMediaCollection('customer_images');
        }

        return redirect()->route('customers.index')->with('success', 'مشتری با موفقیت ویرایش شد.');
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->clearMediaCollection('customer_images');
            $customer->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف مشتری'], 500);
        }
    }

}
