<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
     /** view change password */
     public function changePasswordView()
     {
         return view('auth.changepassword');
     }
     
     /** change password in db */
     public function changePasswordDB(Request $request)
     {
         $request->validate([
             'current_password' => ['required', new MatchOldPassword],
             'new_password' => ['required'],
             'new_confirm_password' => ['same:new_password'],
         ]);
 
         Admin::find(auth('admin')->user()->id)->update(['password'=> Hash::make($request->new_password)]);
         DB::commit();
         Toastr::success('User change successfully :)','Success');
         return redirect()->intended('home');
     }


      /** profile user */
    public function profile()
    {   
        $admin_id = Session::get('admin_id'); // get user_id session
        $admin = Admin::findOrFail($admin_id);
        $admin_courses = Course::where('admin_id',$admin_id)->get();
           
        return view('auth.adminprofile',compact('admin','admin_courses'));
    }

    /** save profile information */
    public function profileInformation(Request $request)
    {
        try {
            $admin = Admin::find($request->id);

            if (!$admin) {
                Toastr::error('Teacher not found!', 'Error');
                return redirect()->back();
            }

            $save_url = $admin->image; // Initialize $save_url variable

            if (!empty($request->image)) {
                $old_image_name = $request->hidden_image;
                $image = $request->file('image');

                if ($image) {
                    $image_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('upload/Admin/'), $image_name);
                    $save_url = 'upload/Admin/' . $image_name;
                }
            }

            $update = [
                'name' => $request->name,
                'image' => $save_url, // Use $save_url here
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'department' => $request->department,
                'description' => $request->description,
            ];

            $admin->update($update);
            Toastr::success('Profile Information updated successfully.', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Failed to update Profile Information.', 'Error');
            return redirect()->back();
        }
    }

}
