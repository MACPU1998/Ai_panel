<?php

namespace App\Http\Controllers;

use App\DataTables\permissionsDataTable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index(permissionsDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.manage-permission');

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

    public function datatable(permissionsDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    public function create()
    {
        return view('admin.layouts.add-permission');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        Permission::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);
        return redirect()->route('permissions.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function edit(Permission $permission)
    {
        return view('admin.layouts.edit-permission', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        $permission->update([
            'name' => $validated['name'],
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
            return response()->json(['success' => false, 'message' => 'خطا در حذف کاربر'], 500);
        }
    }

}
