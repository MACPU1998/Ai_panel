<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserRequest;
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

    public function store(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        // اختصاص نقش به کاربر
       $user->assignRole($validated['role']);

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


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.layouts.users.edit_user', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
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

    public function editPassword(User $user)
    {
        return view('admin.layouts.users.edit_user_password', compact('user'));
    }

    public function updatePassword(User $user, Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // بررسی صحت رمز فعلی
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'رمز فعلی اشتباه است.']);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'رمز عبور با موفقیت تغییر یافت.');

    }

}
