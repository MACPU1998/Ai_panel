<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
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


    public function deposit(Request $request)
    {
        dd('ioi');

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
}
