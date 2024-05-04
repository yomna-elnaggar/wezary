<?php

namespace App\Http\Controllers\dashboard\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    // regiter page 
    public function index()
    {
        
        return view('auth.register');
    }
    // insert new teacher
    public function register(Request $request)
    {
        
        // Validate incoming request
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:admins,email',
            'phone_number'  => 'required|unique:admins,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
            'password'      => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        
        try {
            $dt        = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
            
            $admin = Admin::create([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'phone_number'  => $request->input('phone_number'),
                'join_date' => $todayDate,
                'password'  => Hash::make($request->input('password')),
               	'status' => 'unactive', // Set the status to pending
            ]);
           // Log in the admin using the admin guard
           Auth::guard('admin')->login($admin);;
            Toastr::success('Create new account successfully :)','Success');
            return view('auth.waiting_page');
        }catch(Exception $e) {
            \Log::info($e);
            DB::rollback();
            Toastr::error('Add new Teacher fail :)','Error');
            return redirect()->back();
        }
    }


    public function logout(Request $request)
    {
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $request->session()->forget('join_date');
        $request->session()->forget('phone_number');
        Auth::guard('admin')->logout(); // Logout the admin
        $request->session()->invalidate(); // Invalidate the session

        return redirect('/login'); // Redirect to login page
}
}
