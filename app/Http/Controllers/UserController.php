<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index(usersDataTable $dataTable)
    {
        return $dataTable->render('admin.layouts.manage-user');
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

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف کاربر'], 500);
        }
    }

    public function edit(User $user)
    {
        return view('admin.layouts.edit-user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8'
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);
        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت ویرایش شد.');
    }
}
