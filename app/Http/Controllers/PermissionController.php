<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index(){
        $permissions = Permission::all();
        return view('dashboard.Permissions.permissions')->with('permissions',$permissions);
    }
    public function addPermissionForm(){
        return view('dashboard.Permissions.add');
    }
    public function addPermission(Request $request){
         Permission::create(['name' => $request->permission]);
        return back()->with('success','تم إضافة الصلاحية الجديدة بنجاح');
    }
}
