<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\notifications\NewNotification;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user_id= $request->user()->id;
            $data = Notification::where('user_id',$user_id)->orderby('id','desc')->get();
            $success['success'] = true;
            $success['data'] = $data;
            $success['message'] = __('message.success');
            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
  ////dashboard
   	public function Notification(Request $request)
    {
      if (Auth::guard('admin')->user()->can('access any')) {
        try {
            
        	return view('Notification.Notification');
            
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
      }
    }
  
      public function saveRecord(Request $request)
      {
      
        if(Auth::guard('admin')->user()->can('access any')){
          $test = $request->validate([
            'title'        => 'required',
            'body'       => 'required',
          ]);

        try{
          
           // Send notification to users with matching academic and stage level
            $usersToNotify = User::get();
          	//dd($usersToNotify);

            $message = $request->body;
            $title = $request->title; 

            foreach ($usersToNotify as $user) {
                $user->notify(new NewNotification($message, $title));
            }

          Toastr::success('Add new  Notification successfully :)','Success');
          return redirect()->back();

        }catch(\Exception $e){
          DB::rollback();
          Toastr::error('Add new Notification fail :)','Error');
          return redirect()->back();
        }
      }else {

        return view('errors.403');
      }
      }
  
  
   public function sendNotification(Request $request)
    {
       
     $user= $request->user();
           
               $user_id= $request->user()->id;

                $title = $request->input('title');
                $message = $request->input('text');

                $user->notify(new NewNotification($message, $title));

                Toastr::success('Notification sent successfully :)', 'Success');
                return response()->json(['message' => 'Notification sent successfully'], 200);
           
       
    }
  	
  
  
  
  		
  
   

}
