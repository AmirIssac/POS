<?php

namespace App\Http\Controllers;

use App\PermissionCategory;
use App\PermissionCustom;
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
        $categories = PermissionCategory::all();
        return view('dashboard.Permissions.add')->with('categories',$categories);
    }
    public function store(Request $request){
        Permission::create(['name' => $request->permission,'guard_name'=>'web','category_id'=>$request->cat]);
        return back()->with('success','تم إضافة الصلاحية الجديدة بنجاح');
    }
}
