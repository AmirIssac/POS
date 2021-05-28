<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\PermissionCategory;
use App\Repository;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SettingsController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Settings.index')->with(['repositories'=>$repositories]);   
    }

    public function minForm($id){
        $repository = Repository::find($id);
        return view('manager.Settings.finance')->with('repository',$repository);
    }

    public function min(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update(
            [
                'min_payment' => $request->min,
            ]
            );
            return back()->with('success',' تم تعيين نسبة حد أدنى للدفع جديدة وهي '.$request->min);
    }

    public function tax(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update(
            [
                'tax' => $request->tax,
                'tax_code' => $request->taxcode,
            ]
            );
            return back()->with('success',' تم تعيين الضريبة الجديدة بنجاح ');
    }

    public function app($id){
        $repository = Repository::find($id);
        return view('manager.Settings.app')->with('repository',$repository);
    }

    public function submitApp(Request $request , $id){
        $repository = Repository::find($id);
       
         // Build the input for validation
        $fileArray = array('image' => $request->logo);

        // Tell the validator that this file should be an image
         $rules = array(
        'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
        );

        // Now pass the input and rules into the validator
        $validator = Validator::make($fileArray, $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user 
            // that the provided file was not an adequate type
            //return back()->with(['errors' => $validator->errors()->getMessages()]);
            return back()->with(['errors' => 'خطأ في الملف']);
        } else
        {
            // Store the File Now
            // read image from temporary file
            $imagePath = $request->file('logo')->store('logo', 'public');
            $repository->update(
                [
                    'logo' => $imagePath,
                ]
                );
                return back()->with('success',' تم تعيين الاعدادات  بنجاح ');
        }
    }

    public function addWorkerForm($id){
        $repository = Repository::find($id);
        // all permissions that owner has because its impossible to give worker a permission that the owner dont have
        $permissionsOwner = Role::findByName('مالك-مخزن')->permissions;
        $categories = PermissionCategory::all();
        return view('manager.Settings.add_worker')->with(['repository'=>$repository,'permissionsOwner'=>$permissionsOwner,'categories'=>$categories]);
    }

    public function storeWorker(Request $request , $id){
        $repository = Repository::find($id);
       $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]
            );
            $repository->users()->attach($user->id); //pivot table insert
            $user->assignRole('عامل-مخزن');  // this role will not contain any permission by default but we use role for dashboard
            $user->givePermissionTo($request->permissions);
            return redirect()->route('manager.settings.index')->with('successWorker','تم اضافة موظف جديد للمتجر بنجاح');
  
    }

    public function showWorkers($id){
        $repository = Repository::find($id);
        $users = $repository->users;
        // important closure
        // get all users with worker role and work in this repository
        $workers = User::whereHas("roles", function($q){ $q->where("name", "عامل-مخزن"); })->whereHas("repositories", function($p) use ($repository){ $p->where("repositories.id", $repository->id); })->get();
        return view('manager.Settings.show_workers')->with(['repository'=>$repository,'workers'=>$workers]);
    }

    public function showWorkerPermissions($id){
        $user = User::find($id);
        $permissions_on = $user->getAllPermissions();
        // all permissions that owner has because its impossible to give worker a permission that the owner dont have
        $permissions = Role::findByName('مالك-مخزن')->permissions; 
        $categories = PermissionCategory::all();
        return view('manager.Settings.edit_worker')->with(['categories'=>$categories,'permissionsOwner'=>$permissions,'permissions_on'=>$permissions_on,'user'=>$user,
        ]);
    }   

    public function editWorkerPermissions(Request $request,$id){
        $user = User::find($id);
        $user->syncPermissions($request->permissions);
        return back()->with('success','تم تعديل صلاحيات الموظف بنجاح');
    }
    
}
