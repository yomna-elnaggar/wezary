<?php

namespace App\Http\Controllers\dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Mail;
use Brian2694\Toastr\Facades\Toastr;

class ForgotPasswordController extends Controller
{
    /** get email*/
    public function getEmail()
    {
       return view('auth.passwords.email');
    }

    /** post email */
    public function postEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('auth.verify',['token' => $token], function($message) use ($request) {
            $message->from('wezary@gmail.com');
            $message->to($request->email); /** input your email to send */
            $message->subject('Reset Password Notification');
            });
        Toastr::success('We have e-mailed your password reset link! :)','Success');
        return back();
    }
}
