<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Department;
use App\Models\StageLevel;
use Illuminate\Http\Request;
use App\Models\AcademicLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\notifications\NewNotification;
use App\Models\User;
use App\Models\CourseCode;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function cardAllCourses(Request $request)
    {
      $courses = Course::with(['academicLevel', 'stageLevel', 'department', 'teacher'])->orderBy('id', 'DESC')->get(); 
      $courses = $courses->map(function ($course) {
        $course->academicLevel_name = optional($course->academicLevel)->name ?? 'No Academic Level';
        $course->stageLevel_name = optional($course->stageLevel)->name ?? 'No Stage Level';
        $course->department_name = optional($course->department)->name ?? 'No Department';
        $course->department_name = optional($course->department)->name ?? 'No Department';
        return $course; 
      });
      $academicLevel = AcademicLevel::get();
      $stageLevel = StageLevel::get();
      $departments = Department::get();
      return view('courses.allcoursescard', compact('courses', 'academicLevel', 'stageLevel', 'departments'));

    }

    /** save data courses */
    public function saveRecord(Request $request)
    { 
        $admin_id = Auth::guard('admin')->user()->id;
        
        $test = $request->validate([
            'name'        => 'required|string|max:255',
            
            'academic_level_id' => 'required',
            'stage_level_id'    => 'required',
            'department_id'    => 'required',
            'image'     => 'required',
            'description' =>'required|string' ,
         ]);
        // dd($test);
        $image =$request->file('image');
        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/Course/'), $image_name);
        $save_url = 'upload/Course/'.$image_name;

        $Course = new Course;
        $Course->name         = $request->name;
        
        $Course->academic_level_id   = $request->academic_level_id;
        $Course->stage_level_id       = $request->stage_level_id;
        $Course->department_id  = $request->department_id;
        $Course->image  = $save_url;
        $Course->description  = $request->description;
        $Course->admin_id  = $admin_id;
        $Course->save();

        
        Toastr::success('Add new $Course successfully :)','Success');
        return redirect()->route('all/courses/card');
             
    }

    /** view edit record */
    public function updateRecord(Request $request)
    {
        //dd($request->all());
        try {
            // $validator = Validator::make($request->all(), [
            //     'name'        => 'required|string|max:255',
            //     'code'       => 'nullable|unique:courses',
            //     'academic_level_id' => 'required',
            //     'stage_level_id'    => 'required',
            //     'department_id'    => 'required',
            //     'image'     => 'required',
            //     'description' =>'required|string' 
            // ]);
    
            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }
    
            $Course = Course::find($request->id);
    
            if (!$Course) {
                Toastr::error('Course not found not found!', 'Error');
                return redirect()->back();
            }
    
            $old_image = $Course->image;
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('upload/Course/'), $image_name);
                $save_url = 'upload/Course/'.$image_name;
    
                if ($old_image) {
                    unlink($old_image);
                }
            } else {
                $save_url = $old_image;
            }
    
            $Course->update([
                'name' => $request->name,
                
                'academic_level_id'  => $request->academic_level_id,
                'stage_level_id'       => $request->stage_level_id,
                'department_id'  => $request->department_id,
                'image' => $save_url,
                'description' => $request->description,
            ]);
    
            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->route('all/courses/card');
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord(Request $request)
    {
            
      $Course = Course::find($request->id);

      if (!$Course) {
        Toastr::error('Course not found not found!', 'Error');
        return redirect()->back();
      }

      if ($Course->image) {
        unlink($Course->image);
      }
      $Course->delete();
      Toastr::success('Delete record successfully :)','Success');
      return redirect()->route('all/courses/card');
            
      
    }

    /** courses search */
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

    /** Course profile  */
    public function profileCourses($courses_id)
    {   
      	$course = Course::findOrFail($courses_id);
        if(Auth::guard('admin')->user()->can('access any')||Auth::guard('admin')->user()->id == $course->admin_id ) {
            
            $course->academicLevel_name = optional($course->academicLevel)->name ?? 'No Academic Level';
            $course->stageLevel_name = optional($course->stageLevel)->name ?? 'No Stage Level';
            $course->department_name = optional($course->department)->name ?? 'No Department';
               $subjects = Subject::where('course_id', $course->id)->orderBy('id', 'DESC')->get();
            $subjects = $subjects->map(function ($subject) {
                $subject->course_name = optional($subject->course)->name ?? 'No course';
                return $subject; 
            });
			//dd($subjects);
            
            return view('courses.coursesprofile',compact('course', 'subjects'));
    
        }else {
       
        return view('errors.403');
        }

    
    }

    /** just admin approv coures  */

    public function approv($courses_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            $course = Course::findOrFail($courses_id);

            // Toggle the status between 'active' and 'unactive'
            $newStatus = $course->status === 'active' ? 'unactive' : 'active';

            $course->update([
                'status' => $newStatus,
            ]);
          
          if($course->status == 'active')
          {
          	 // Send notification to users with matching academic and stage level
            $usersToNotify = User::where('academic_level_id', $course->academic_level_id)
                ->where('stage_level_id', $course->stage_level_id)
                ->get();
          	//dd($usersToNotify);

            $message = "تم اضافة كورس جديد: " . $course->name;
            $title = "كورس جديد"; 

            foreach ($usersToNotify as $user) {
                $user->notify(new NewNotification($message, $title));
            }
          }

            Toastr::success('Record updated successfully!', 'Success');

            return redirect()->route('all/courses/card');
        } else {
            return view('errors.403');
        }
    }
  
   	public function saveCourseCode(Request $request)
    {
		//dd($request->all());
        // Validate the request
        $validatedData = $request->validate([
            'generated_code_input' => 'required',
            'course_id' => 'required|integer',
        ]);

        // Create a new CourseCode instance and save the code along with the course ID
        $courseCode = new CourseCode();
        $courseCode->name = $validatedData['generated_code_input'];
        $courseCode->course_id = $validatedData['course_id'];
        $courseCode->save();

         Toastr::success('Record updated successfully!', 'Success');
      	return redirect()->back();
    }

}
