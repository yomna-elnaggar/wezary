<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\course\CourseResources;

class DepartmentController extends Controller
{
    public function departmentCourses(Request $request)
    {
        try {
           
            $user = $request->user();
            $department_id = $request->department_id;
            $courses = Course::where('academic_level_id',$user->academic_level_id)
                        ->where('stage_level_id' ,$user->stage_level_id)->where('department_id',$department_id)->latest()->get();

            $success['success'] = true;
            $success['data'] = CourseResources::collection($courses);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
