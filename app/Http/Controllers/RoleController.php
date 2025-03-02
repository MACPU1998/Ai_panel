<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.manage_role');

    }

    public function create()
    {
        //گرفتن نام گاردهای موجود در سیستم
        $guards = Config::get('auth.guards', []); // مقدار پیش‌فرض آرایه خالی
        $guards = is_array($guards) ? array_keys($guards) : [];
        return view('admin.layouts.add_role', compact('guards'));
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->validated());
        return redirect()->route('roles.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function getRolesData(Request $request)
    {
        $role = Role::query();

        return DataTables::of($role)
            ->addColumn('action', function ($role) {
                return '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(RolesDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Role $role)
    {

        return view('admin.layouts.edit_role', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return redirect()->route('roles.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function destroy(Role $role)
    {
        try {
            // جدا کردن وابستگی‌ها (در صورت وجود)
            $role->roles()->detach(); // جدا کردن ارتباط با نقش‌ها
            $role->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف کاربر'], 500);
        }
    }

    public function showList($roleId)
    {
        $roles = Role::findOrFail($roleId); // دریافت نقش از دیتابیس
        $permissions = Permission::all();
        return view('admin.layouts.role_list', compact('roles', 'permissions'));
    }

    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        $role = Role::findOrFail($request->role_id); // پیدا کردن نقش انتخاب شده
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn("id", $request->permissions)
                ->pluck('name')->toArray();
            // اختصاص مجوزهای انتخاب‌شده به نقش (مجوزهای قبلی حذف می‌شوند)
            if ($permissions)
                $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }


        return back()->with('success', 'مجوزها با موفقیت اختصاص داده شدند.');
    }

}
