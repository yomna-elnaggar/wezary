<?php

namespace App\Http\Controllers\Api;

use App\Models\StageLevel;
use Illuminate\Http\Request;
use App\Models\AcademicLevel;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function academicLevel()
    {
        try {
            $academicLevels = AcademicLevel::get();

            $success['success'] = true;
            $success['data'] = $academicLevels;
            $success['message'] = 'success';
    
            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function stageLevel(Request $request)
    {
        try {
        
            $stageLevels = StageLevel::where('academic_level_id',$request->academic_level_id)->get();
          
            $success['success'] = true;
            $success['data'] = $stageLevels;
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
