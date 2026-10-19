<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.admins.manage_admin');
    }

    public function show(Admin $admin)
    {
        $admin->load('roles');

        return view('admin.layouts.admins.show', compact('admin'));
    }


    public function create()
    {
        $roles = Role::all();
        session()->forget('_old_input'); // حذف اطلاعات ورودی قبلی
        return view('admin.layouts.admins.add_admin', compact('roles'));
    }

    public function store(AdminRequest $request)
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

        return redirect()->route('admins.index')->with('success', 'کاربر با موفقیت ایجاد شد');
    }
    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();

        return view('admin.layouts.admins.edit', compact('admin', 'roles'));
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
