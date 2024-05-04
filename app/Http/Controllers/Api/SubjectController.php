<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\subject\SubjectResources;

class SubjectController extends Controller
{
    public function UserAttachSubject(Request $request)
    {
        try {
           
            $user = $request->user();
            $subject_id = $request->subject_id;
            $subject = Subject::where('id',$subject_id)->first();
    
            if (!$user->subjects->contains($subject_id)) {
                $user->subjects()->attach($subject_id,['attending_min'=> 0]);
        
            }

            $success['success'] = true;
            $success['data'] = new SubjectResources($subject);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

	 public function AttendingMin(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'subject_id' => 'required|exists:subjects,id',
                'attending_min' => 'required|integer|min:0', 
            ]);
            
            $user = $request->user();
            $subject_id = $request->subject_id;
            $attending_min = $request->attending_min;
            $subject = Subject::find($subject_id);

            if ($user->subjects->contains($subject_id)) {
                // Update the attending_min value for the specific subject
                $user->subjects()->updateExistingPivot($subject_id, ['attending_min' => $attending_min]);
            }

            $success['success'] = true;
            $success['message'] = 'Attendance minutes updated successfully';
            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
