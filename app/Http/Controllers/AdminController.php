<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AdminPasswordUpdateRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // لیست ادمین‌ها
    public function index()
    {
        return view('admin.layouts.admins.index');
    }

    // دریافت اطلاعات برای دیتاتیبل
    public function getAdminsData(Request $request)
    {
        $admins = Admin::query();

        return datatables()->eloquent($admins)
            ->addColumn('action', function (Admin $admin) {
                $url = route('admins.edit', [
                    'admin' => $admin->id,
                ]);

                return '<a href="' . $url . '" class="btn btn-primary">
                    ویرایش
                </a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    // ویرایش ادمین انتخاب‌شده
    public function edit(Admin $admin)
    {
        $roles = Role::all();

        return view(
            'admin.layouts.admins.edit',
            compact('admin', 'roles')
        );
    }

    // ذخیره تغییرات ادمین انتخاب‌شده
    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $validated = $request->validated();

        $admin->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if (isset($validated['role'])) {
            $admin->syncRoles([$validated['role']]);
        }

        return redirect()
            ->route('admins.index')
            ->with('success', 'اطلاعات ادمین با موفقیت ویرایش شد.');
    }
}
