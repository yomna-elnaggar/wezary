<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        // Fetch permission
        if (Auth::guard('admin')->user()->can('access permission')) {
            $permission = Permission::get();
            return view('backend.permission.index', compact('permission'));
        } else {
            // Handle no permission scenario
            return abort(403, 'Unauthorized action.');
        }
    }
    public function create()
    {
        if (Auth::guard('admin')->user()->can('add permission')) {
            return view('backend.permission.create');
        } else {
            return abort(403, 'Unauthorized action.');
        }
       
    }
    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->canany(['access permission','add permission'])) {
            $request->validate([
                'name' => 'required',
            ]);
    
            Permission::create([
                'name' => $request->name,
                'guard_name' => 'admin',
            ]);
    
            return redirect()->route('permission.all')->with('msg', 'تم اضافة التصنيف');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function edit(string $id)
    {
        if (Auth::guard('admin')->user()->can('edit permission')) {
            $permission = Permission::findOrFail($id);
        return view('backend.permission.edit', compact('permission'));
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, string $id)
    {
        if (Auth::guard('admin')->user()->canany(['access permission','edit permission'])) {
            $permission = Permission::findOrFail($id);
            $permission->name = $request->name;
            $permission->update();
            return redirect()->route('permission.all')->with('msg', 'تم تحديث المعلومات');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }


    public function destroy(string $id)
    {
        if (Auth::guard('admin')->user()->can('delete permission')) {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return redirect()->back()->with('msg', 'تم حذف التصنيف');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
