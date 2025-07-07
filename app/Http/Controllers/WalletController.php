<?php

namespace App\Http\Controllers;

use App\DataTables\WalletDataTable;
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

    public function store(Request $request)
    {

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


    public function edit(Wallet $wallet)
    {
        $admin = auth('admin')->user();
        $customer = $wallet->customer;
        return view('admin.layouts.wallets.edit_wallet', compact('admin', 'customer', 'wallet'));

    }

    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $customer = $wallet->customer;
        $admin = auth('admin')->user();

        $oldBalance = $wallet->balance;
        $newBalance = $request->balance;
        $difference = $newBalance - $oldBalance;

        $wallet->balance = $newBalance;
        $wallet->save();
        $type = $difference < 0 ? 0 : 1; // 0 = کاهش (decrease), 1 = افزایش (increase)

        if ($difference != 0) {
            WalletTransaction::create([
                'wallet_id'   => $wallet->id,
                'amount'     => abs($difference),
                'type'        => $type,
                'description' => $request->description,
                'admin_id'    => $admin->id,
            ]);
        }

        return redirect()->route('wallets.index')->with('success', 'مقدار کیف پول با موفقیت به‌روزرسانی شد.');
    }


//    public function update(Request $request, Customer $customer)
//    {
//        $request->validate([
//            'balance' => 'required|numeric',
//            'description' => 'nullable|string',
//        ]);
//
//        $wallet = $customer->wallet;
//
//        if (!$wallet) {
//            $wallet = Wallet::create([
//                'customer_id' => $customer->id,
//                'balance' => 0,
//            ]);
//
//            // مقدار قبلی
//            $oldBalance = $wallet->balance;
//
//            // مقدار جدید: جمع مقدار قبلی با عدد ورودی
//            $wallet->balance = $request->balance;
//            $wallet->save();
//
//            // اختلاف بین مقدار جدید و قبلی
//            $difference = $wallet->balance - $oldBalance;
//
//            // تعیین نوع تراکنش
//            $type = $difference < 0 ? '-' : '+';
//
//            // ذخیره تراکنش
//            WalletTransaction::create([
//                'wallet_id' => $wallet->id,
//                'amount' => $difference,
//                'type' => $type,
//                'description' => $request->description,
//                'admin_id' => auth('admin')->id(),
//
//            ]);
//
//        } else {
//            // اگر کیف پول وجود دارد، فقط آپدیت می‌کنیم
//            $oldBalance = $wallet->balance;
//            $wallet->balance = $request->balance;
//            $wallet->save();
//
//            $difference = $wallet->balance - $oldBalance;
//            $type = $difference < 0 ? 'decrease' : 'increase';
//
//            Wallet::create([
//                'customer_id' => $customer->id,
//                'balance' => $difference,
//            ]);
//            WalletTransaction::create([
//                'wallet_id' => $wallet->id,
//                'amount' => abs($difference),
//                'type' => $type,
//                'description' => $request->description,
//                'admin_id' => auth('admin')->id(),
//
//            ]);
//        }
//        return redirect()->route('wallets.index')->with('success', 'مقدار کیف پول با موفقیت به‌روزرسانی شد.');
//
//    }


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
