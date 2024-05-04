<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\course\CourseResources;

class FavouriteCourseController extends Controller
{
    public function addToFavorites(Request $request)
    {
        $user = $request->user();
        $course_id = $request->course_id;
        // Check if the product is not already in the favorites
        if (!$user->favorites()->where('course_id', $course_id)->exists()) {
             $user->favorites()->attach($course_id, ['user_id' => $user->id]);
    
            return response()->json(['success' => true, 'message' => 'course added to favorites']);
        }
    
        return response()->json(['success' => false, 'message' => 'course is already in favorites']);
    }
    
   public function removeFromFavorites(Request $request)
   {
     $user = $request->user();
     $course_id = $request->course_id;

     // Check if the course exists in user's favorites
     if (!$user->favorites()->where('course_id', $course_id)->exists()) {
       return response()->json(['success' => false, 'message' => 'Course not found in favorites'], 404);
     }

     // Remove the course from favorites
     $user->favorites()->detach($course_id);

     return response()->json(['success' => true, 'message' => 'Course removed from favorites']);
   }
    
    public function myFavoriteCourses(Request $request)
    {
        $user = $request->user();
        
        $favoriteCourses = $user->favorites()->get();
        $data = CourseResources::collection($favoriteCourses);
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'success',
        ], 200);
    }
}
