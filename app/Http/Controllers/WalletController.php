<?php

namespace App\Http\Controllers;

use App\DataTables\WalletDataTable;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WalletController extends Controller
{
    public function index(WalletDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.wallets.manage_wallet');
    }

    public function create()
    {
       return view('admin.layouts.wallets.add_wallet');
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $admin = Admin::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);
        // اختصاص نقش به کاربر
        $admin->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    public function getWalletData(Request $request)
    {
        $wallet = Wallet::query();

        return DataTables::of($wallet)
            ->addColumn('action', function ($wallet) {
                return '<a href="' . route('wallets.edit', $wallet->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(WalletDataTable $dataTable)
    {
        return $dataTable->ajax();
    }


    public function edit(Admin $admin,Customer $customer, Wallet $wallet)
    {
        return view('admin.layouts.wallets.edit_wallet', compact('admin', 'customer', 'wallet'));

    }

//    public function update(UserUpdateRequest $request, Admin $admin)
//    {
//    }
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $wallet = $customer->wallet;

        if (!$wallet) {
            $wallet = Wallet::create([
                'customer_id' => $customer->id,
                'balance' => 0,
            ]);

            // مقدار قبلی
            $oldBalance = $wallet->balance;

            // مقدار جدید: جمع مقدار قبلی با عدد ورودی
            $wallet->balance = $request->balance;
            $wallet->save();

            // اختلاف بین مقدار جدید و قبلی
            $difference = $wallet->balance - $oldBalance;

            // تعیین نوع تراکنش
            $type = $difference < 0 ? '-' : '+';

            // ذخیره تراکنش
            WalletTransaction::create([
                'wallet_id'   => $wallet->id,
                'amount'     => $difference,
                'type'        => $type,
                'description' => $request->description,
                'admin_id' => auth('admin')->id(),

            ]);

        }
        else {
            // اگر کیف پول وجود دارد، فقط آپدیت می‌کنیم
            $oldBalance = $wallet->balance;
            $wallet->balance = $request->balance;
            $wallet->save();

            $difference = $wallet->balance - $oldBalance;
            $type = $difference < 0 ? 'decrease' : 'increase';

            WalletTransaction::update([
                'wallet_id'   => $wallet->id,
                'amount'     => abs($difference),
                'type'        => $type,
                'description' => $request->description,
                'admin_id' => auth('admin')->id(),

            ]);
        }
        return redirect()->route('wallets.index')->with('success', 'مقدار کیف پول با موفقیت به‌روزرسانی شد.');

    }


    public function destroy(Wallet $wallet)
    {
        try {
            $wallet->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف کیف پول'], 500);
        }
    }

}
