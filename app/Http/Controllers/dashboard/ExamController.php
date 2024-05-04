<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ExamsResources;
use App\Models\Exam;
use App\Models\Course;
use App\Models\User;
use App\Models\Admin;
use PDF;
class ExamController extends Controller
{
    public function exams($id)
    {
        $admin_id = Auth::guard('admin')->user()->id;
       	$student = User::find($id); 
        $exams = Exam::where('user_id',$student->id)->orderBy('id', 'DESC')->get(); 
        $courses = Course::where('admin_id' ,$admin_id)->get();

 		$exams = $exams->map(function ($exam) {
        $exam->teacher_name = optional($exam->teacher)->name ?? 'No teacher ';
        $exam->course_name = optional($exam->course)->name ?? 'No course ';
      
        return $exam; 
      });
      	
        return view('students.exam',compact('exams','courses','student'));
    }
  /** save data courses */
    public function saveRecord(Request $request)
    { 
      //dd($request->all());
        $admin_id = Auth::guard('admin')->user()->id;
        
        $image =$request->file('image');
        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/exam/'), $image_name);
        $save_url = 'upload/exam/'.$image_name;

        $Exam = new Exam;
        $Exam->name         = $request->name;
        $Exam->user_id   = $request->student_id;
        $Exam->grade       = $request->grade;
        $Exam->image  = $save_url;
        $Exam->admin_id  = $admin_id;
        $Exam->save();

        
        Toastr::success('Add new Exam successfully :)','Success');
        return redirect()->back();
             
    }
  
      /** delete record */
    public function deleteRecord(Request $request)
    {
            
      $Exam = Exam::find($request->id);

      if (!$Exam) {
        Toastr::error('Exam not found not found!', 'Error');
        return redirect()->back();
      }

      if ($Exam->image) {
        unlink($Exam->image);
      }
      $Exam->delete();
      Toastr::success('Delete record successfully :)','Success');
      return redirect()->back();
            
      
    }
  
     public function generatePDF($students_id)
    {
	//dd(students_id);
     
       	//$admin_id = Auth::guard('admin')->user()->id;
       	$student = User::find($students_id); 
        $exams = Exam::where('user_id',$student->id)->orderBy('id', 'DESC')->get(); 
        
 		$exams = $exams->map(function ($exam) {
        $exam->teacher_name = optional($exam->teacher)->name ?? 'No teacher ';
        $exam->course_name = optional($exam->course)->name ?? 'No course ';
      
        return $exam; 
      });
      	
       $data = [
         	'title' => 'تقرير امتحانات الطالب',
            'date' => date('m/d/Y'),
            'student' => $student,
          	'exams' => $exams
        ]; 

        
		$pdf = PDF::loadView('students.exampdf', $data);
        $doc = 'report';
        return $pdf->stream($doc . '.pdf');

	//return $pdf->download('report.pdf');
    }

  
  	////api
	public function ApiExam(Request $request)
    {
       
      try {
           
            $user = $request->user();
            
            $Exams = Exam::where('user_id',$user->id)->orderBy('id', 'DESC')->get();
            $Exams = $Exams->map(function ($exam) {
                    $exam->teacher_name = optional($exam->teacher)->name ?? 'No teacher ';
                    $exam->course_name = optional($exam->course)->name ?? 'No course ';

              return $exam; 
             });
            $success['success'] = true;
            $success['data'] =  ExamsResources::collection($Exams);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
 
    }
}
