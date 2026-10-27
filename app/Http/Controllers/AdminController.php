<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function datatable(AdminsDataTable $dataTable)
    {
        return $dataTable->ajax();
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

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth('admin')->id()) {
            return response()->json(['success' => false, 'message' => 'نمی‌توانید حساب خودتان را حذف کنید.'], 403);
        }

        if ($this->isLastSuperAdmin($admin)) {
            return response()->json(['success' => false, 'message' => 'آخرین سوپر ادمین قابل حذف نیست.'], 422);
        }

        $admin->delete();

        return response()->json(['success' => true]);
    }


    private function isLastSuperAdmin(Admin $admin): bool
    {
        return $admin->hasRole('super-admin')
            && Admin::role('super-admin', 'admin')->count() <= 1;
    }

    public function editPassword(Admin $admin)
    {
        return view('admin.layouts.admins.edit_admin_password', compact('admin'));
    }

    public function updatePassword(Admin $admin, Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'رمز فعلی اشتباه است.']);
        }

        $admin->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admins.index')->with('success', 'رمز عبور با موفقیت تغییر یافت.');

    }
}
