<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\course\CourseResources;
use App\Http\Resources\course\CourseDetilsResources;
use App\notifications\NewNotification;

class CourseController extends Controller
{
    public function Course(Request $request)
    {
        try {
           
            $user = $request->user();
            $course_id = $request->course_id;
            $course = Course::where('id',$course_id)->with('subjects')->first();

            $success['success'] = true;
            $success['data'] = new CourseDetilsResources($course);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

   	public function CourseSubscription(Request $request)
    {
       
            $user = $request->user();
            $course_id = $request->course_id;
            $courseCode = $request->courseCode;
            $course = Course::where('id', $course_id)->with('subjects')->first();

            $foundCode = false;
            $codeToUpdate = null;

            foreach ($course->CourseCodes as $code) {
                if ($code->name === $courseCode) {
                    if ($code->availability === 1) {
                        // Return a response indicating the code has been taken before
                        $success['success'] = false;
                        $success['message'] = 'This code has been used previously';
                        return response()->json($success, 404);
                    } else if ($code->availability === 0 && !$foundCode) {
                        $foundCode = true;
                        $codeToUpdate = $code; // Assign the code to update
                    }
                }
            }

      //dd($foundCode);
            if ($foundCode && $codeToUpdate !== null) {
                if (!$user->courses->contains($course_id)) {
                    // Attach user to the course
                    $user->courses()->attach($course_id);
                    // Update availability of the code to indicate it has been used
                    $codeToUpdate->update(['availability' => 1]);
                    // Send notification to user
                    $message = "تم تفعيل اشتراكك في كورس : " . $course->name;
                    $title = " تم التفعيل بنجاح";
                    $user->notify(new NewNotification($message, $title));
                    // Subscription successful
                    $success['success'] = true;
                    $success['message'] = 'Subscription successful';
                    return response()->json($success, 200);
                } else {
                    // User has already subscribed to the course
                    $success['success'] = false;
                    $success['message'] = 'You have previously subscribed to the course';
                    return response()->json($success, 200);
                }
            } else {
                // Invalid code or code not available
                $success['success'] = false;
                $success['message'] = 'Invalid code or code is not available';
                return response()->json($success, 200);
            }
       
    }



  
  	public function MyCourses(Request $request)
    {
        try{
            $user = $request->user();
            $MyCourses = $user->courses;

            foreach ($MyCourses as $course) {
                // Calculate total minutes for all subjects in this course
                $totalMinutes = $course->subjects ? $course->subjects->sum('totale_min') : 0;
                $totalSeconds = $course->subjects ? $course->subjects->sum('totale_sec') : 0;
                $totalMinutes += round($totalSeconds / 60);

                // Get the subjects attached to the user in this course
                $subjects = $course->subjects->filter(function ($subject) use ($user) {
                    return $user->subjects->contains($subject);
                });

                $course->subjects = $subjects;

                // Calculate the sum of attending_min for the user's subjects in this course
                $attendingMinSum = $subjects->sum(function ($subject) use ($user) {
                    return $user->subjects->where('id', $subject->id)->first()->pivot->attending_min ?? 0;
                });

                $course->attending_min_sum = $attendingMinSum;

                // Calculate the percentage
                $percentage = $totalMinutes != 0 ? ($attendingMinSum / $totalMinutes) * 100 : 0;
                $course->percentage = intval($percentage); 
            }
            $data = CourseResources::collection($MyCourses);
        
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success',
            ], 200);
        
        }catch (\Exception $e) {
                    
                    return response()->json(['error' => $e->getMessage()], 500);
                }
    }
}
