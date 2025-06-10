<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(usersDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.users.manage_user');
    }

    public function create()
    {
        $roles = Role::all();
        session()->forget('_old_input'); // حذف اطلاعات ورودی قبلی
        return view('admin.layouts.users.add_user', compact('roles'));
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

    public function getUsersData(Request $request)
    {
        $users = User::query();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="' . route('users.edit', $user->id) . '" class="btn btn-primary">ویرایش</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function datatable(UsersDataTable $dataTable)
    {
        return $dataTable->ajax();
    }


    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.layouts.users.edit_user', compact('admin', 'roles'));
    }

    public function update(UserUpdateRequest $request, Admin $admin)
    {
        $validated = $request->validated();
        $admin->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);
        $admin->syncRoles($validated['role']);

        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت ویرایش شد.');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف کاربر'], 500);
        }
    }

    public function editPassword(Admin $admin)
    {
        return view('admin.layouts.users.edit_user_password', compact('admin'));
    }

    public function updatePassword(Admin $admin, Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // بررسی صحت رمز فعلی
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'رمز فعلی اشتباه است.']);
        }

        $admin->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'رمز عبور با موفقیت تغییر یافت.');

    }

}
