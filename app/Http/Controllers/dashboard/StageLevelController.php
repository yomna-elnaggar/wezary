<?php

namespace App\Http\Controllers\dashboard;

use App\Models\StageLevel;
use Illuminate\Http\Request;
use App\Models\AcademicLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class StageLevelController extends Controller
{
    
      /** page designations */
      public function stageLevelIndex()
      {
        $stageLevels = StageLevel::with('academicLevel')->get();
        $academicLevel = AcademicLevel::get();
        
         $stageLevels = $stageLevels->map(function ($stageLevel) {
                $stageLevel->academicLevel_name = optional($stageLevel->academicLevel)->name ?? 'No Academic Level';
          
                return $stageLevel;
            });

        return view('educational.stageLevel',compact('stageLevels','academicLevel'));
      }
  
      public function saveRecordStageLevel(Request $request)
      {
      
        if(Auth::guard('admin')->user()->can('access any')){
          $test = $request->validate([
            'name'        => 'required|string|max:255',
            'academic_level_id'       => 'required',
          ]);

        try{

          $stageLevel = new StageLevel;
          $stageLevel->name         = $request->name;
          $stageLevel->academic_level_id  = $request->academic_level_id;
          $stageLevel->save();

          Toastr::success('Add new stage Level successfully :)','Success');
          return redirect()->back();

        }catch(\Exception $e){
          DB::rollback();
          Toastr::error('Add new stage Level fail :)','Error');
          return redirect()->back();
        }
      }else {

        return view('errors.403');
      }
      }
  
      public function updateRecordStageLevel(Request $request)
      {
        if(Auth::guard('admin')->user()->can('access any')){
          try {

              $StageLevel = StageLevel::find($request->id);

              if (!$StageLevel) {
                  Toastr::error('Stage Level not found not found!', 'Error');
                  return redirect()->back();
              }

              $StageLevel->update([
                  'name' => $request->name,
                  'academic_level_id' => $request->academic_level_id,
              ]);

              Toastr::success('Record updated successfully!', 'Success');
               return redirect()->back();
          } catch (\Exception $e) {
              Toastr::error('Failed to update record!', 'Error');
              return redirect()->back();
          }
        }else {

          return view('errors.403');
        }
      }
  
  
      public function deleteRecordStageLevel(Request $request)
      {
       if(Auth::guard('admin')->user()->can('access any')){
        try {
            StageLevel::destroy($request->id);
              Toastr::success('Stage Level deleted successfully :)','Success');
              return redirect()->back();
          
          } catch(\Exception $e) {
              DB::rollback();
              Toastr::error('Stage Level delete fail :)','Error');
              return redirect()->back();
          }
       }else {

         return view('errors.403');
       }
      }
  
}
