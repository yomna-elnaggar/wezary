<?php

namespace App\Http\Controllers\dashboard;

use App\Models\About;
use Illuminate\Http\Request;
use App\Models\Communication;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class AboutWezaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['AboutUs','TermsConditions','GetCommunication']);
    }

    public function AboutWezary()
    {
        $abouts = About::get();
        return view('about.about',compact('abouts'));
    }

    public function updateRecord(Request $request)
    {
        try {
            $About = About::find($request->id);

            if (!$About) {
                Toastr::error('About not found not found!', 'Error');
                return redirect()->back();
            }

            $About->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->route('all/AboutWezary');
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
    }

    public function Communication()
    {
        $Communications = Communication::get();
        return view('about.communication',compact('Communications'));
    }

    public function updateCommunication(Request $request)
    {
        try {
            $Communication = Communication::find($request->id);

            if (!$Communication) {
                Toastr::error('Communication not found not found!', 'Error');
                return redirect()->back();
            }

            $Communication->update([
                'Linkedin' => $request->Linkedin,
                'Facebook' => $request->Facebook,
                'Telegram' => $request->Telegram,
                'Whatsapp' => $request->Whatsapp,
                'Google' => $request->Google,
            ]);

            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->route('all/Communication');
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
    }

    /**AboutUs api **/ 
    public function AboutUs(){
         try {
            
            $About = About::findOrFail(1);
           
            $success['success'] = true;
            $success['data'] = $About;
            $success['message'] = 'success';
            return response()->json($success, 200);
        }catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function TermsConditions(){
        try {
           
           $About = About::findOrFail(2);
          
           $success['success'] = true;
           $success['data'] = $About;
           $success['message'] = 'success';
           return response()->json($success, 200);
       }catch (\Exception $e) {
           
           return response()->json(['error' => $e->getMessage()], 500);
       }

   }
  
  	public function GetCommunication(){
        try {
           
           $Communication = Communication::findOrFail(1);
          
           $success['success'] = true;
           $success['data'] = $Communication;
           $success['message'] = 'success';
           return response()->json($success, 200);
       }catch (\Exception $e) {
           
           return response()->json(['error' => $e->getMessage()], 500);
       }

   }
}
