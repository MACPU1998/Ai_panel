<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.manage-role');

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

    public function create()
    {
        return view('admin.layouts.add-role');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        Role::create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);
        return redirect()->route('roles.index')->with('success', 'کاربر با موفقیت ویرایش شد.');

    }

    public function edit(Role $role)
    {
        return view('admin.layouts.edit-role', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'guard_name' => 'required|string|min:3|max:255',
        ]);
        $role->update([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);
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

}
