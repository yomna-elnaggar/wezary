<?php

namespace App\Http\Controllers\dashboard\Auth;

use DB;
use Session;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $admin =  Auth::guard('admin')->user();

            // Check if the admin is active
            if ($admin->status == 'active') {
                // Store session data
                Session::put('admin_id', $admin->id);
                Session::put('name', $admin->name);
                Session::put('email', $admin->email);
                Session::put('join_date', $admin->join_date);
                Session::put('phone_number', $admin->phone_number);

                // Authentication passed, redirect to home
                Toastr::success('Login successfully :)', 'Success');
                return redirect()->intended('home');
            } else {
                // If user is not active, redirect to waiting page
                Toastr::info('حسابك غير فعال. الرجاء الانتظار لموافقة المشرف.', 'Info');
                return view('auth.waiting_page');
            }
        }

        // Authentication failed
        Toastr::error('Authentication failed: Incorrect email or password.', 'Error');
        return redirect('login');
    }
}
