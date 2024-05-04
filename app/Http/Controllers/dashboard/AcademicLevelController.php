<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\AcademicLevel;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class AcademicLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /** page departments */
    public function index()
    {
        $academicLevel = AcademicLevel::get();
        return view('educational.academicLevel',compact('academicLevel'));
    }

    /** save record department */
    public function saveRecordAcademicLevel(Request $request)
    {
      if (Auth::guard('admin')->user()->can('access any')) {
          $request->validate([
              'name' => 'required|string|max:255',
          ]);

          try {

              $academicLevel = AcademicLevel::where('name',$request->name)->first();
              if ($academicLevel === null)
              {
                  $academicLevel = new AcademicLevel;
                  $academicLevel->name = $request->name;
                  $academicLevel->save();
                  Toastr::success('Add new Academic Level successfully :)','Success');
                  return redirect()->back();
              } else {
                  DB::rollback();
                  Toastr::error('Add new Academic Level exits :)','Error');
                  return redirect()->back();
              }
          } catch(\Exception $e) {
              DB::rollback();
              Toastr::error('Add new Academic Level fail :)','Error');
              return redirect()->back();
          }
         } else {
            return view('errors.403');
        }
    }

    /** update record department */
    public function updateRecordAcademicLevel(Request $request)
    {
      if(Auth::guard('admin')->user()->can('access any')) {
          try {
            // update table departments
            $academicLevel = [
              'id'=>$request->id,
              'name'=>$request->name,
            ];
            AcademicLevel::where('id',$request->id)->update($academicLevel);

            Toastr::success('updated record successfully :)','Success');
            return redirect()->back();
          } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('updated record fail :)','Error');
            return redirect()->back();
          }
       } else {
            return view('errors.403');
        }
       
    }

    /** delete record department */
    public function deleteRecordAcademicLevel(Request $request) 
    {
      if(Auth::guard('admin')->user()->can('access any')) {
        try {
        AcademicLevel::destroy($request->id);
            Toastr::success('Academic Level deleted successfully :)','Success');
            return redirect()->back();
        
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Academic Level delete fail :)','Error');
            return redirect()->back();
        }
      } else {
        return view('errors.403');
      }
    }
    /** delete record department */

  
}
