<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Wallet\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WalletController extends Controller
{


    public function test(): JsonResponse
    {

        return response()->json([
            'wallet_id' =>  'wallet_id',
            'admin_id' =>'admin_id',

        ]);
    }


    public function editWallet(Customer $customer): View
    {
        return view('admin.layouts.customers.wallet_customer', compact('customer'));

    }

    public function updateWallet(Request $request, Customer $customer)
    {


        $request->validate([
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $wallet = $customer->wallet;

        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $customer->id,
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
        $type = $difference < 0 ? 'decrease' : 'increase';

        // ذخیره تراکنش
        WalletTransaction::create([
            'wallet_id'   => $wallet->id,
            'balance'     => $difference,
            'type'        => $type,
            'description' => $request->description,
            'created_by' => auth('admin')->id(),

        ]);

        }
        else {
            // اگر کیف پول وجود دارد، فقط آپدیت می‌کنیم
            $oldBalance = $wallet->balance;
            $wallet->balance = $request->balance;
            $wallet->save();

            $difference = $wallet->balance - $oldBalance;
            $type = $difference < 0 ? 'decrease' : 'increase';

            WalletTransaction::create([
                'wallet_id'   => $wallet->id,
                'amount'     => abs($difference),
                'type'        => $type,
                'description' => $request->description,
                'created_by' => auth('admin')->id(),

            ]);
        }
        return redirect()->route('customers.index')->with('success', 'مقدار کیف پول با موفقیت به‌روزرسانی شد.');

    }

    //getAdminWallet
    public function showOrCreate($adminId): JsonResponse
    {
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $wallet = $admin->wallet()->firstOrCreate([
            'admin_id' => $admin->id,
        ], [
            'balance' => 0,
        ]);

        return response()->json([
            'wallet_id' => $wallet->id,
            'admin_id' => $admin->id,
            'balance' => $wallet->balance,
        ]);
    }


    public function deposit(Request $request, $adminId): JsonResponse
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        $wallet = $admin->wallet()->first();
        if (!$wallet) {
            return response()->json(['error' => 'Wallet not found'], 404);
        }

        // افزایش موجودی
        $wallet->balance += $request->amount;
        $wallet->save();

        // ثبت تراکنش
        $wallet->transactions()->create([
            'type' => 'deposit',
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Deposit successful',
            'new_balance' => $wallet->balance,
        ]);

    }

    private function getOrCreateWalletForUser($user, $relation = 'wallet')
    {
        return $user->$relation()->firstOrCreate([], ['balance' => 0]);
    }

}
