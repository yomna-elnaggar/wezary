<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentsController extends Controller
{
    public function students()
    {
       
        $students = User::whereNotNull('special_code')->orderBy('id', 'DESC')->get(); 
        $students = $students->map(function ($student) {
        $student->academicLevel_name = optional($student->academicLevel)->name ?? 'No Academic Level';
        $student->stageLevel_name = optional($student->stageLevel)->name ?? 'No Stage Level';
          $countryCode = '966'; // Assuming the country code is '966' (you can change this as per your requirements)
          $phoneNumber = $student->phone_number;
          $parent_phone = $student->parent_phone;
      	  $student->numberPart = substr($phoneNumber, strlen($countryCode));
          $student->parent_numberPart = substr($parent_phone, strlen($countryCode));
        return $student; 
        });

    	
		
        return view('students.students',compact('students'));
        
        
    }

    public function deleteRecord(Request $request)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            try{
            $student = User::find($request->id);

            if (!$student) {
                Toastr::error('student not found not found!', 'Error');
                return redirect()->back();
            }

            if ($student->pic_identityF) {
                unlink($student->pic_identityF);
            }

            if ($student->pic_identityB) {
                unlink($student->pic_identityB);
            }
            $student->delete();
                Toastr::success('student deleted successfully :)','Success');
                return redirect()->back();
            
            } catch(\Exception $e) {
                DB::rollback();
                Toastr::error('Stage Level delete fail :)','Error');
                return redirect()->back();
            }

        }else{
            
            return view('errors.403');
        }
    }

     /** list search employee */
     public function studentsSearch(Request $request)
    {
        try {
            $query = User::query();

            // Search by name
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
            }

            // Search by special_code
            if ($request->filled('special_code')) {
                $query->where('special_code', $request->input('special_code'));
            }

            // Execute the query and get the results
            $students = $query->get();

            // Transform the data
            $students = $students->map(function ($student) {
                $student->academicLevel_name = optional($student->academicLevel)->name ?? 'No Academic Level';
                $student->stageLevel_name = optional($student->stageLevel)->name ?? 'No Stage Level';
                return $student;
            });

            return view('students.students', compact('students'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function profileStudent($students_id)
    {
            $student = User::findOrFail($students_id); 

            $student->academicLevel_name = optional($student->academicLevel)->name ?? 'No Academic Level';
            $student->stageLevel_name = optional($student->stageLevel)->name ?? 'No Stage Level';
            $courses = $student->courses;

            foreach ($courses as $course) {
                // Calculate total minutes for all subjects in this course
                $totalMinutes = $course->subjects ? $course->subjects->sum('totale_min') : 0;
                $totalSeconds = $course->subjects ? $course->subjects->sum('totale_sec') : 0;
                $totalMinutes += round($totalSeconds / 60);

                // Get the subjects attached to the user in this course
                $subjects = $course->subjects->filter(function ($subject) use ($student) {
                    return $student->subjects->contains($subject);
                });

                $course->subjects = $subjects;

                // Calculate the sum of attending_min for the user's subjects in this course
                $attendingMinSum = $subjects->sum(function ($subject) use ($student) {
                    return $student->subjects->where('id', $subject->id)->first()->pivot->attending_min ?? 0;
                });

                $course->attending_min_sum = $attendingMinSum;

                // Calculate the percentage
                $percentage = $totalMinutes != 0 ? ($attendingMinSum / $totalMinutes) * 100 : 0;
                $course->percentage = intval($percentage); 
            }

            return view('students.studentProf', compact('student', 'courses'));
        
    }
    public function toggel($students_id)
    {
        try {
            $student = User::findOrFail($students_id);
            $status = $student->status;
            $newStatus = $status === 'active' ? 'unactive' : 'active'; // Toggle the status

            $student->update([
                'status' => $newStatus,
            ]);

            Toastr::success('Student status toggled successfully.', 'Success');
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            Toastr::error('Student not found.', 'Error');
            return redirect()->back();
        }
    }
  
    public function twoDivdivse(Request $request)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            try{
            $student = User::find($request->id);

            if (!$student) {
                Toastr::error('student not found not found!', 'Error');
                return redirect()->back();
            }

            $student->update([
            'two_devices'=>1,
            
              ]);
                Toastr::success('student updated successfully :)','Success');
                return redirect()->back();
            
            } catch(\Exception $e) {
                DB::rollback();
                Toastr::error('Stage Level delete fail :)','Error');
                return redirect()->back();
            }

        }else{
            
            return view('errors.403');
        }
    }
}


 

        
    

