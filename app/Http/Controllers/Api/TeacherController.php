<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\teacher\TeacherDetailsResource;

class TeacherController extends Controller
{
    public function teacher(Request $request)
    {
        try {
           
            $user = $request->user();
            $teacher_id = $request->teacher_id;
            $teacher = Admin::findOrFail($teacher_id);
            

            $success['success'] = true;
            $success['data'] = new TeacherDetailsResource($teacher);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
