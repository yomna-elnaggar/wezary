<?php

namespace App\Http\Controllers\dashboard;

use DB;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddTeacherRequest;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function cardAllTeachers(Request $request)
    {
      
      $admins= Admin::orderBy('id', 'DESC')->get(); 
      return view('teachers.allteacherscard',compact('admins'));
    }

    /** all employee list */
    public function listAllTeachers()
    {
       $admins= Admin::orderBy('id', 'DESC')->get();
      return view('teachers.teacherslist',compact('admins'));
    }
    
     /** save data employee */
    public function saveRecord(Request $request)
    { 
      
     if (Auth::guard('admin')->user()->can('access any')) {
       $test = $request->validate([
             'name'        => 'required|string|max:255',
             'email'       => 'required|email|unique:admins,email',
             'phone_number'   => 'required|unique:admins,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|min:10',
             'gender'      => 'required|string|max:255',
             'department'     => 'required',
             'image'     => 'required',
             'password' =>'required|string|min:8',
             'description' =>'required|string' ,
         ]);
         try{
 
             $teacher = Admin::where('email', '=',$request->email)->first();
             if ($teacher === null)
             {
                $dt        = Carbon::now();
                $todayDate = $dt->toDayDateTimeString();

                $image =$request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('upload/Admin/'), $image_name);
                $save_url = 'upload/Admin/'.$image_name;
 
                 $teacher = new Admin;
                 $teacher->name         = $request->name;
                 $teacher->email        = $request->email;
                 $teacher->phone_number   = $request->phone_number;
                 $teacher->gender       = $request->gender;
                 $teacher->department  = $request->department;
                 $teacher->join_date =  $todayDate;
                 $teacher->image = $save_url ;
                 $teacher->description = $request->description;
                 $teacher->Password      = Hash::make($request->input('password'));
                 $teacher->save();
     
                 Toastr::success('Add new Teahcer successfully :)','Success');
                 return redirect()->route('all/teachers/card');
             } else {
                 DB::rollback();
                 Toastr::error('Add new Teacher exits :)','Error');
                 return redirect()->back();
             }
         }catch(\Exception $e){
             DB::rollback();
             Toastr::error('Add new Teacher fail :)','Error');
             return redirect()->back();
         }
     }else {

       return view('errors.403');
     }
    }

    /** view edit record */
    public function viewRecord($teachers_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            $teacher = Admin::findOrFail($teachers_id);
            return view('teachers.edit.editteacher',compact('teacher'));
        }else {
            
            return view('errors.403');
        }
    }

    public function updateRecord(Request $request)
    {
       if (Auth::guard('admin')->user()->can('access any')) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:admins,email,' . $request->id,
                'gender' => 'nullable|string|in:Male,Female',
                'department' => 'nullable|string',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'password' => 'nullable|string|min:8',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $admin = Admin::find($request->id);
    
            if (!$admin) {
                Toastr::error('Teacher not found not found!', 'Error');
                return redirect()->back();
            }
    
            $old_image = $admin->image;
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('upload/Admin/'), $image_name);
                $save_url = 'upload/Admin/'.$image_name;
    
               
            } else {
                $save_url = $old_image;
            }
    
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'department' => $request->department,
                'image' => $save_url,
                'password' => $request->password ? Hash::make($request->password):$admin->password ,
                'description' => $request->description,
            ]);
    
            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->route('all/teachers/card');
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
    }else {

      return view('errors.403');
    }
    }

    /** delete record */
    public function deleteRecord($teachers_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            try{
                $admin = Admin::find($teachers_id);
        
                if (!$admin) {
                    Toastr::error('Teacher not found not found!', 'Error');
                    return redirect()->back();
                }
        
               
                $admin->delete();
                Toastr::success('Delete record successfully :)','Success');
                return redirect()->route('all/teachers/card');
            }catch(\Exception $e){
                DB::rollback();
                Toastr::error('Delete record fail :)','Error');
                return redirect()->back();
            }
        }else {
                
            return view('errors.403');
        }
    }

    /** employee search */
    public function TeachersSearch(Request $request)
    {
        $query = DB::table('admins')->select('admins.*');
       
        // Search by name
        if ($request->name) {
            $query->where('admins.name', 'LIKE', '%' . $request->name . '%');
        }
    
        // Search by department name
        if ($request->department) {
            $query->where('admins.department', 'LIKE', '%' . $request->department . '%');
        }
    
        // Execute the query and get the results
        $admins = $query->get();
    
        // Return the view with the admins data
        return view('teachers.allteacherscard', compact('admins'));
    }

    /** list search employee */
    public function teachersListSearch(Request $request)
    {
        $query = DB::table('admins')->select('admins.*');
        // Search by name
        if ($request->name) {
            $query->where('admins.name', 'LIKE', '%' . $request->name . '%');
        }
        // Search by department name
        if ($request->department) {
            $query->where('admins.department', 'LIKE', '%' . $request->department . '%');
        }
        // Execute the query and get the results
        $admins = $query->get();
        return view('teachers.teacherslist', compact('admins'));

    }

    /** employee profile with all controller user */
    public function profileTeachers($teachers_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            $teacher = Admin::findOrFail($teachers_id);
          	$courses =	$teacher->courses;
          	$courses = $courses->map(function ($course) {
                $course->academicLevel_name = optional($course->academicLevel)->name ?? 'No Academic Level';
                $course->stageLevel_name = optional($course->stageLevel)->name ?? 'No Stage Level';
                $course->department_name = optional($course->department)->name ?? 'No Department';
                $course->department_name = optional($course->department)->name ?? 'No Department';
                return $course; 
            });
          	
          	$allUsers = collect(); 

            foreach ($courses as $course) {
                $users = $course->users;
                $allUsers = $allUsers->merge($users); 
            }

            return view('teachers.teachersprofile',compact('teacher','courses','allUsers'));
    
        }else {
       
        return view('errors.403');
        }

    
    }
  
    public function active($Admin_id)
    {
     // dd($Admin_id);
        try {
            $Admin = Admin::findOrFail($Admin_id);
            

            $Admin->update([
                'status' => 'active',
            ]);

            Toastr::success('techer status toggled successfully.', 'Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error('teacher not found.', 'Error');
            return redirect()->back();
        }
    }

}
