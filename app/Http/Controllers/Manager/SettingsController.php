<?php

namespace App\Http\Controllers\Manager;

use App\Customer;
use App\Http\Controllers\Controller;
use App\PermissionCategory;
use App\Repository;
use App\Type;
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

    public function maxDiscount(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update([
            'max_discount' => $request->max_discount,
        ]);
        return back()->with('success',' تم تعيين  الحد الأعلى للخصم بنجاح ');
    }

    public function app($id){
        $repository = Repository::find($id);
        return view('manager.Settings.app')->with('repository',$repository);
    }

    public function submitApp(Request $request , $id){
        $repository = Repository::find($id);
       
        if($request->file('logo')){
         // Build the input for validation
        $fileArray = array('image' => $request->logo);

        // Tell the validator that this file should be an image
         $rules = array(
        'image' => 'mimes:jpeg,jpg,png,gif|max:10000' // max 10000kb
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
            $imagePath = $request->file('logo')->store('logo/'.$repository->id, 'public');
            $repository->update(
                [
                    'logo' => $imagePath,
                ]
                );
            }
        }
            
                return back()->with('success',' تم تعيين الاعدادات  بنجاح ');
        
    }

    public function generalSettings(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update([
            'name' => $request->repo_name,
            'address' => $request->address,
            'close_time' => $request->close_time,
            'note' => $request->note,
        ]);
        return back()->with('success','تم تغيير الاعدادت العامة بنجاح');
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
        /*$validated = $request->validate([
            'email' => 'unique:users|email',
        ]);*/
        $user = User::where('email',$request->email)->first();
        if($user && $user->hasRole('عامل-مخزن')){   // this worker exist in another repo
            // check if this user exist in the same repo to not added twice at same repo
            $worker = User::whereHas("repositories", function($q) use ($repository){ $q->where("repositories.id",$repository->id ); })->where('email',$request->email)->first();
            if(!$worker)
            $repository->users()->attach($user->id); //pivot table insert
            else
            return redirect()->route('manager.settings.index')->with('fail','هذا الموظف موجود في هذا الفرع');
        }
        else{
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
        }
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

    public function clients($id){
        $repository =  Repository::find($id);
        $customers = $repository->customers()->orderBy('points','DESC')->paginate(15);
        return view('manager.Settings.clients')->with(['repository'=>$repository,'customers'=>$customers]);
    }

    public function editClient($id){
        $customer = Customer::find($id);
        return view('manager.Settings.edit_client')->with('customer',$customer);
    }

    public function updateClient(Request $request,$id){
        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return back()->with('success','تم التعديل بنجاح');
    }

    public function editWorkerInfo($id){
        $user = User::find($id);
        return view('manager.Settings.edit_worker_info')->with('user',$user);
    }
    public function updateWorkerInfo(Request $request , $id){
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return back()->with('success','تم التعديل بنجاح');
    }
    
}
