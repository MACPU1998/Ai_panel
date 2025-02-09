<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionsDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index(PermissionsDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.manage-permission');

    }

    public function create()
    {
        //گرفتن نام گاردهای موجود در سیستم
        $guards = Config::get('auth.guards', []); // مقدار پیش‌فرض آرایه خالی
        $guards = is_array($guards) ? array_keys($guards) : [];
        return view('admin.layouts.add-permission', compact('guards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        Permission::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'guard_name' => $validated['guard_name'],
        ]);
        return redirect()->route('permissions.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function getPermissionsData(Request $request)
    {
        $permission = Permission::query();

        return DataTables::of($permission)
            ->addColumn('action', function ($permission) {
                return '<a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(PermissionsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function edit(Permission $permission)
    {
        //گرفتن نام گاردهای موجود در سیستم
        $guards = Config::get('auth.guards', []); // مقدار پیش‌فرض آرایه خالی
        $guards = is_array($guards) ? array_keys($guards) : [];
        return view('admin.layouts.edit-permission', compact('permission', 'guards'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'slug' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        $permission->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'guard_name' => $validated['guard_name'],
        ]);
        return redirect()->route('permissions.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function destroy(Permission $permission)
    {
        try {
            // جدا کردن وابستگی‌ها (در صورت وجود)
            $permission->roles()->detach(); // جدا کردن ارتباط با نقش‌ها
            $permission->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف نقش'], 500);
        }
    }

}
