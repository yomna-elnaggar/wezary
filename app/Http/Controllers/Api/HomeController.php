<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\course\CourseResources;
use App\Http\Resources\teacher\TeacherResources;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\course\CourseRecentlyResources;

class HomeController extends Controller
{
    ///recently attached cource
    public function recentlyCourse(Request $request)
    {
        try {
              	$user = $request->user();
			  	$recentlyCourse = $user->courses()->latest()->first();
          		if(!$recentlyCourse){
                    $success['success'] = true;
                    $success['data'] = null;
                    $success['message'] = 'no  recently Course';
                    return response()->json($success, 200);
       
                }
          		$totalMinutes = $recentlyCourse->subjects ? $recentlyCourse->subjects->sum('totale_min') : 0;
                $totalSeconds = $recentlyCourse->subjects ? $recentlyCourse->subjects->sum('totale_sec') : 0;
                $totalMinutes += round($totalSeconds / 60);
 				$hours = floor($totalMinutes / 60);
        		$minutes = $totalMinutes % 60;
         		$duration = $totalMinutes > 0 ? $hours . 'h' . $minutes . 'm' : 0 . 'h' . 0 . 'm';
       			$recentlyCourse->duration  = $duration;
                // Get the subjects attached to the user in this course
                $subjects = $recentlyCourse->subjects->filter(function ($subject) use ($user) {
                    return $user->subjects->contains($subject);
                });

                $recentlyCourse->subjects = $subjects;

                // Calculate the sum of attending_min for the user's subjects in this course
                $attendingMinSum = $subjects->sum(function ($subject) use ($user) {
                    return $user->subjects->where('id', $subject->id)->first()->pivot->attending_min ?? 0;
                });

                $recentlyCourse->attending_min_sum = $attendingMinSum;

                // Calculate the percentage
                $percentage = $totalMinutes != 0 ? ($attendingMinSum / $totalMinutes) * 100 : 0;
                $recentlyCourse->percentage = intval($percentage); 
            
            $success['success'] = true;
            $success['data'] = new CourseRecentlyResources($recentlyCourse);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function recentlyCourses(Request $request)
    {
        try {
           
            $user = $request->user();
            $recentlyCourse = Course::where('academic_level_id',$user->academic_level_id)
                        ->where('stage_level_id' ,$user->stage_level_id)->latest()->active()->get();
            

            $success['success'] = true;
            $success['data'] = CourseResources::collection($recentlyCourse);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function departments(Request $request)
    {
        try {
           
            $user = $request->user();
            $department = Department::where('academic_level_id',$user->academic_level_id)
                        ->where('stage_level_id' ,$user->stage_level_id)->latest()->get();

            $success['success'] = true;
            $success['data'] = DepartmentResource::collection($department);
            $success['message'] = 'message.success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function teachers(Request $request)
    {
        try {
           
            $user = $request->user();
            $teachers = Admin::whereNotIn('id', [1])->get();

            $success['success'] = true;
            $success['data'] = TeacherResources::collection($teachers);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    
}
