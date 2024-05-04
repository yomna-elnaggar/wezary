<?php

namespace App\Http\Controllers\dashboard;

use Gate;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
      
    
    }

    public function index()
    {
        if (Auth::guard('admin')->user()->can('access role')) {
            // Fetch roles
            $role = Role::get();
           
            return view('backend.role.index', compact('role'));
        } else {
            // Handle no permission scenario
            return abort(403, 'Unauthorized action.');
        }
    }
    public function create()
    {
        if (Auth::guard('admin')->user()->can('add role')) {
            $permissions = Permission::get();
            return view('backend.role.create',compact('permissions'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
    public function store(Request $request)
    {//dd($request->permissions);
        if (Auth::guard('admin')->user()->canany(['access role','add role'])) {
            $request->validate([
                'name' => 'required',
            ]);
    
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'admin',
            ]);
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('role.all')->with('msg', 'تم اضافة التصنيف');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
    public function edit(string $id)
    {
        if (Auth::guard('admin')->user()->can('edit role')) {
            $role = Role::findOrFail($id);
            $permissions = Permission::get();
            $role->permissions;
        return view('backend.role.edit', compact(['role','permissions']));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
    public function update(Request $request, string $id)
    {
        if (Auth::guard('admin')->user()->canany(['access role','edit role'])) {
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->update();
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('role.all')->with('msg', 'تم تحديث المعلومات');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function destroy(string $id)
    {
        if (Auth::guard('admin')->user()->can('delete role')) {
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->back()->with('msg', 'تم حذف التصنيف');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
