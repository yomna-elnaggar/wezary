<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Department;
use App\Models\StageLevel;
use Illuminate\Http\Request;
use App\Models\AcademicLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /** all department list */
    public function listAllDepartments()
    {
        
            $departments = Department::with(['academicLevel', 'stageLevel'])->get(); 
            $academicLevel = AcademicLevel::get();
            $stageLevel = StageLevel::get();
            
            // Handle cases where academicLevel and stageLevel relationships might be null
            $departments = $departments->map(function ($department) {
                $department->academicLevel_name = optional($department->academicLevel)->name ?? 'No Academic Level';
                $department->stageLevel_name = optional($department->stageLevel)->name ?? 'No Stage Level';
                return $department;
            });
        
            return view('educational.department', compact('departments', 'academicLevel', 'stageLevel'));
        
    }

    public function getstageLevel($academic_level_id)
    {

        $stageLevels= StageLevel::where('academic_level_id',$academic_level_id)->pluck('name','id');
        return $stageLevels;
    }

     /** save data Department */
     public function saveRecord(Request $request)
     { 
       if (Auth::guard('admin')->user()->can('access any')) {
      
          $test = $request->validate([
                'name'              => 'required|string|max:255',
                'academic_level_id' => 'required',
                'stage_level_id'    => 'required',
                'icon'              => 'required',
            ]);

            try{
                $department = Department::where('name', $request->name)->first();
                if ($department === null) {
                   $icon = $request->file('icon');
                   $icon_name = hexdec(uniqid()) . '.' . $icon->getClientOriginalExtension();
                   $icon->move(public_path('upload/Department/'), $icon_name);
                   $save_url = 'upload/Department/' . $icon_name;

                    $department = new Department;
                    $department->name = $request->name;
                    $department->icon = $save_url;
                    $department->academic_level_id = $request->academic_level_id;
                    $department->stage_level_id = $request->stage_level_id;
                    $department->save();

                    Toastr::success('Add new Department successfully :)', 'Success');
                    return redirect()->back();
                } else {
                    DB::rollback();
                    Toastr::error('Department already exists :)', 'Error');
                    return redirect()->back();
                }
            } catch(\Exception $e) {
                DB::rollback();
                Toastr::error('Add new Department failed :(', 'Error');
                return redirect()->back();
            }
         } else {
            return view('errors.403');
        }
     }
     

    /** view edit record */
    public function viewRecord($department_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            $department = Department::findOrFail($department_id);
            $academicLevel = AcademicLevel::get();
            $stageLevel = StageLevel::get();
        
            if ($department->academicLevel) {
                $department->academicLevel_name = $department->academicLevel->name;
            } else {
                $department->academicLevel_name = 'No academic Level'; // or any default value you prefer
            };
            
            return view('educational.editdpartment', compact('department', 'academicLevel', 'stageLevel'));
        }else {
            
            return view('errors.403');
        }
    }

    public function updateRecord(Request $request)
    {
       if (Auth::guard('admin')->user()->can('access any')) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'academic_level_id' => 'nullable|exists:academic_levels,id',
                'stage_level_id' => 'nullable|exists:stage_levels,id',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $department = Department::find($request->id);
    
            if (!$department) {
                Toastr::error('Department not found not found!', 'Error');
                return redirect()->back();
            }
    
            $old_icon = $department->icon;
    
            if ($request->hasFile('icon')) {
                $icon = $request->file('icon');
                $icon_name = hexdec(uniqid()).'.'.$icon->getClientOriginalExtension();
                $icon->move(public_path('upload/Department/'), $icon_name);
                $save_url = 'upload/Department/'.$icon_name;
    
                if ($old_icon) {
                    unlink($old_icon);
                }
            } else {
                $save_url = $old_icon;
            }
    
            $department->update([
                'name' => $request->name,
                'academic_level_id' => $request->academic_level_id,
                'stage_level_id' => $request->stage_level_id,
                'icon' => $save_url,
            ]);
    
            Toastr::success('Record updated successfully!', 'Success');
            return redirect()->route('all/department/list');
        } catch (\Exception $e) {
            Toastr::error('Failed to update record!', 'Error');
            return redirect()->back();
        }
         
        }else {
            
            return view('errors.403');
        }
    }

    /** delete record */
    public function deleteRecord($department_id)
    {
        if (Auth::guard('admin')->user()->can('access any')) {
            try{
                $department = Department::find($department_id);
        
                if (!$department) {
                    Toastr::error('Department not found not found!', 'Error');
                    return redirect()->back();
                }
        
                if ($department->icon) {
                    unlink($department->icon);
                }
                $department->delete();
                Toastr::success('Delete record successfully :)','Success');
                return redirect()->route('all/department/list');
            }catch(\Exception $e){
                DB::rollback();
                Toastr::error('Delete record fail :)','Error');
                return redirect()->back();
            }
        }else {
                
            return view('errors.403');
        }
    }

    /** list search department */
    public function departmentListSearch(Request $request)
    {
        $query = DB::table('departments')
            ->leftJoin('academic_levels', 'departments.academic_level_id', '=', 'academic_levels.id')
            ->leftJoin('stage_levels', 'departments.stage_level_id', '=', 'stage_levels.id')
            ->select('departments.*', 'academic_levels.name as academicLevel_name','stage_levels.name as stageLevel_name');
        //$departmentes = Department::get();
        // Search by name
        if ($request->name) {
            $query->where('departments.name', 'LIKE', '%' . $request->name . '%');
        }
        // Execute the query and get the results
        $departments = $query->get();
        $academicLevel = AcademicLevel::get();
        $stageLevel = StageLevel::get();
        return view('educational.department', compact('departments','academicLevel','stageLevel'));

    }

   
}
