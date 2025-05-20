<?php

namespace App\Http\Controllers;
use App\DataTables\OrderDataTable;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderDataTable $dataTable )
    {
        return $dataTable->render('admin.layouts.orders.manage_order');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('admin.layouts.orders.add_order', compact('countries','states','cities'));;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getOrdersData()
    {
        $customer = Order::query();

        return DataTables::of($customer)
            ->addColumn('action', function ($order) {
                return '<a href="' . route('orders.edit', $order->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(OrderDataTable $dataTable)
    {
        return $dataTable->ajax();
    }
}
