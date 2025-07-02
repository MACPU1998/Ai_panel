<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\DataTables\WalletDataTable;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Admin;
use App\Models\User;
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


    public function edit(Admin $admin)
    {
        return view('admin.layouts.wallets.edit_wallet');

    }

    public function update(UserUpdateRequest $request, Admin $admin)
    {
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
