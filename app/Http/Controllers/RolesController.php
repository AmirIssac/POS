<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    //
    public function index(){
        $roles = Role::all();
        return view('dashboard.Roles.roles')->with('roles',$roles);
    }
    public function addRoleForm(){
        return view('dashboard.Roles.add');
    }
    public function addRole(Request $request){
         Role::create(['name' => $request->role]);
        return back()->with('success','تم إضافة المنصب الجديد بنجاح');
    }
    public function editRolePermissionForm($id){
        $role = Role::find($id); // role i want to edit
        $permissions = Permission::all();
        $role_permissions = $role->permissions;  // get all permissions for specific role
        return view('dashboard.Roles.edit_permissions')->with(['role'=>$role,'permissions'=>$permissions,'role_permissions'=>$role_permissions]);
    }
    public function editRolePermissions(Request $request,$id){
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);
        return back()->with('success','تم التعديل بنجاح');
    }
}
