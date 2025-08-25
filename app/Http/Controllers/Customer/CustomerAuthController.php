<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.dashboard', compact('customer'));
    }

    public function index()
    {
        return view('customer.layouts.auth.login-customer2');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->route('customer.dashboard');
        }
        return back()->withErrors(['email' => 'ایمیل یا رمز عبور اشتباه است.'])->withInput($request->only('email', 'remember'));
    }

    public function edit()
    {
        $customer= Auth::guard('customer')->user();
        return view('customer.layouts.customer.edit_customer', compact('customer'));
    }

//    public function update(AdminUpdateRequest $request, Admin $admin)
//    {
//        $admin->update($request->validated());
//
//        return redirect()->route('admin.dashboard')->with('success', 'مشخصات شما با موفقیت بروزرسانی شد.');
//    }
//
//    public function editPassword()
//    {
//
//        $admin = Auth::guard('admin')->user();
//        return view('admin.layouts.admin.edit_admin_password', compact('admin'));
//    }
//
//    public function updatePassword(AdminPasswordUpdateRequest $request)
//    {
//        $admin = Auth::guard('admin')->user();
//
//        if (!Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
//            return back()->withErrors(['current_password' => 'رمز عبور  فعلی اشتباه است.']);
//        }
//
//        $admin->password = bcrypt($request->password);
//        $admin->save();
//
//        // Re-login the user
//        Auth::guard('admin')->login($admin);
//        return redirect()->route('admin.dashboard')->with('success', 'مشخصات شما با موفقیت بروزرسانی شد.');
//    }
//
//    public function logout()
//    {
//        Auth::guard('admin')->logout();
//
//        return redirect()->route('admin.login');
//    }
}
