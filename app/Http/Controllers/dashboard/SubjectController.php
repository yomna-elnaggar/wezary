<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\notifications\NewNotification;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /** save data Subject */
    public function saveRecord(Request $request)
    { 
        //dd($request->all());
        $admin_id = Auth::guard('admin')->user()->id;
        
        $test = $request->validate([
            'name' => 'required|string|max:255',
            'totale_min' => 'required',
          	'totale_sec' => 'required',
            'link' => 'required',
            'status' => 'required',
            'drive_link' => 'required',
            'description' => 'required|string' ,
        ]);

        $Subject = new Subject;
        $Subject->name         = $request->name;
        $Subject->totale_min        = $request->totale_min;
      	$Subject->totale_sec        = $request->totale_sec;
        $Subject->link   = $request->link;
        $Subject->status       = $request->status;
        $Subject->drive_link  = $request->drive_link;
        $Subject->course_id  = $request->course_id;
        $Subject->description  = $request->description;
        $Subject->admin_id  = $admin_id;
        $Subject->save();

      
       	// Send notification to users with matching academic and stage level
      	 $course = $Subject->course;
         $usersToNotify =$course->users;
          	//dd($usersToNotify);

            $message = "تم اضافة درس جديد الي دورة : " . $course->name;
            $title = " درس جديد"; 

            foreach ($usersToNotify as $user) {
                $user->notify(new NewNotification($message, $title));
            }
        Toastr::success('Add new Subject successfully :)','Success');
        return redirect()->back();
             
    }

    /** view edit record */
    public function updateRecord(Request $request)
    {
        try {
    
            $Subject = Subject::find($request->id);
    
            if (!$Subject) {
                Toastr::error('Subject not found!', 'Error');
                return redirect()->back();
            }
    
            $Subject->update([
                'name' => $request->name,
                'totale_min' =>  $request->totale_min,
              	'totale_sec' =>  $request->totale_sec,
                'link' =>  $request->link,
                'status' =>  $request->status,
                'drive_link' =>  $request->drive_link,
                'description' =>  $request->description ,
            ]);
    
            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            try{
                $Subject = Subject::find($request->id);
       
                if (!$Subject) {
                    Toastr::error('Subject not found !', 'Error');
                    return redirect()->back();
                }
        
                $Subject->delete();
                Toastr::success('Delete record successfully :)','Success');
                return redirect()->back();
            }catch(\Exception $e){
                DB::rollback();
                Toastr::error('Delete record fail :)','Error');
                return redirect()->back();
            }
        }else {
                
            return view('errors.403');
        }
    }

    /** courses search 
    public function coursesSearch(Request $request)
    {
        $query = Course::query();

        // Search by course name
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // Search by admin name
        if ($request->admin_name) {
            $query->whereHas('teacher', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->admin_name . '%');
            });
        }

        // Execute the query and get the results
        $courses = $query->get();
        $courses = $courses->map(function ($course) {
            $course->academicLevel_name = optional($course->academicLevel)->name ?? 'No Academic Level';
            $course->stageLevel_name = optional($course->stageLevel)->name ?? 'No Stage Level';
            $course->department_name = optional($course->department)->name ?? 'No Stage Level';
            return $course; 
        });
        $academicLevel = AcademicLevel::get();
        $stageLevel = StageLevel::get();
        $departments = Department::get();

        // Return the view with the courses data
        return view('courses.allcoursescard', compact('courses','academicLevel','stageLevel','departments'));
    }

     Course profile  
public function profileCourses($courses_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            $course = Course::findOrFail($courses_id);
            $course->academicLevel_name = optional($course->academicLevel)->name ?? 'No Academic Level';
            $course->stageLevel_name = optional($course->stageLevel)->name ?? 'No Stage Level';
            $course->department_name = optional($course->department)->name ?? 'No Department';
            return view('courses.coursesprofile',compact('course'));
    
        }else {
       
        return view('errors.403');
        }

    
    }*/
}
