<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Models\User;
use App\Models\Country;
use App\Models\Government;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;
use App\Http\Controllers\Controller;
use App\Traits\UploadSingleImageTrait;
use App\Http\Resources\User\UserResources;
use App\Http\Resources\User\UserUpdateResource;
use App\Http\Requests\Auth\UpdateProfileRequest;

class ProfileController extends Controller
{
   use UploadSingleImageTrait;

    public function profile(Request $request){
        
        try {
            $user = $request->user();
            
            $success['success'] = true;
            $success['data'] =  new UserResources($user);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }
    }

    public function update( UpdateProfileRequest $request){
       
        try {
            $user = $request->user();
            $validatedData =  $request->validated();
            if($request->hasFile('image')){
                $image = $request->file('image');
                $uploadedImages = $this->processSingleImage($image, 'User/', true);
    
                $validatedData['image'] = $uploadedImages; 
            }
            $user->update($validatedData);
            
            $success['success'] = true;
            $success['data'] = new UserResources($user);
            $success['message'] = 'message.success';
            return response()->json($success, 200);
           
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }
        
    }
    
    public function destroy(Request $request){

        try {
            $user =$request->user();
            $user->delete();
           
            $success['success'] = true;
            $success['message'] = 'success destroy';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => __($e->getMessage())], 500);
        }

    
    }
}
