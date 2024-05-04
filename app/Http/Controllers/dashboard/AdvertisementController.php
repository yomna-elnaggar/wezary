<?php

namespace App\Http\Controllers\dashboard;

use App\Models\StageLevel;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdvertisementResource;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['allAdvertisement','oneAdvertisement']);
    }

    public function advertisement()
    { 
      if(Auth::guard('admin')->user()->can('access any')){
        $advertisements = Advertisement::get();
        return view('advertisement.advertisement',compact('advertisements'));
        }else {
       
        return view('errors.403');
        }
    }

    public function saveRecord(Request $request)
    {
    
    $test = $request->validate([
        'title'        => 'required|string|max:255',
        'image'       => 'required',
        'description' => 'required'
    ]);

    try{

        $image =$request->file('image');
        $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/Advertisement/'), $image_name);
        $save_url = 'upload/Advertisement/'.$image_name;

        $advertisement = new Advertisement;
        $advertisement->title  = $request->title;
        $advertisement->image  = $save_url;
        $advertisement->description  = $request->description;
        $advertisement->save();
        Toastr::success('Add new Advertisement  successfully :)','Success');
        return redirect()->back();
        
    }catch(\Exception $e){
        DB::rollback();
        Toastr::error('Add new Advertisement fail :)','Error');
        return redirect()->back();
    }
    }

    public function updateRecord(Request $request)
    {
    try {
        $Advertisement = Advertisement::find($request->id);

        if (!$Advertisement) {
            Toastr::error('Advertisement not found not found!', 'Error');
            return redirect()->back();
        }

        $old_image = $Advertisement->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/Advertisement/'), $image_name);
            $save_url = 'upload/Advertisement/'.$image_name;

            if ($old_image) {
                unlink($old_image);
            }
        } else {
            $save_url = $old_image;
        }

        $Advertisement->update([
            'title' => $request->name,
            'image' => $save_url,
            'description' => $request->description,
        ]);

        Toastr::success('Record updated successfully!', 'Success');
        return redirect()->route('all/advertisement');
    } catch (\Exception $e) {
        Toastr::error('Failed to update record!', 'Error');
        return redirect()->back();
    }
    }

    public function deleteRecord(Request $request)
    {
    try{
        $Advertisement = Advertisement::find($request->id);

        if (!$Advertisement) {
            Toastr::error('Advertisement not found not found!', 'Error');
            return redirect()->back();
        }

        if ($Advertisement->image) {
            unlink($Advertisement->image);
        }
        $Advertisement->delete();
            Toastr::success('Advertisement deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Stage Level delete fail :)','Error');
            return redirect()->back();
        }
    }

  
     public function allAdvertisement(Request $request){
         try {
            
            $advertisements = Advertisement::get();
           
            $success['success'] = true;
            $success['data'] = AdvertisementResource::collection($advertisements);
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**advertisement api **/ 
    public function oneAdvertisement(Request $request){
        try {
           
           $advertisement = Advertisement::findOrFail($request->id);
          
           $success['success'] = true;
           $success['data'] = new AdvertisementResource($advertisement);
           $success['message'] = 'success';
           return response()->json($success, 200);
       }catch (\Exception $e) {
           
           return response()->json(['error' => $e->getMessage()], 500);
       }

   }


    


    
}
