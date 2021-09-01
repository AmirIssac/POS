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
            return back()->with('success',__('alerts.new_min_pay_set_success').$request->min);
    }

    public function tax(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update(
            [
                'tax' => $request->tax,
                'tax_code' => $request->taxcode,
            ]
            );
            return back()->with('success',__('alerts.new_tax_set_success'));
    }

    public function maxDiscount(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update([
            'max_discount' => $request->max_discount,
        ]);
        return back()->with('success',__('alerts.new_max_discount_set_success'));
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
            return back()->with(['errors' => __('alerts.error_file')]);
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
            
                return back()->with('success',__('alerts.settings_set_success'));
        
    }

    public function generalSettings(Request $request , $id){
        $repository = Repository::find($id);
        $repository->update([
            'name' => $request->repo_name,
            'name_en' =>$request->repo_name_en,
            'address' => $request->address,
        ]);
        return back()->with('success',__('alerts.general_settings_chaanged_success'));
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
            return redirect()->route('manager.settings.index')->with('fail',__('alerts.employee_exist_fail'));
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
            return redirect()->route('manager.settings.index')->with('successWorker',__('alerts.new_employee_add_success'));
  
    }

    public function showWorkers($id){
        $repository = Repository::find($id);
        $users = $repository->users;
        // important closure
        // get all users with worker role and work in this repository
        $workers = User::whereHas("roles", function($q){ $q->where("name", "عامل-مخزن"); })->whereHas("repositories", function($p) use ($repository){ $p->where("repositories.id", $repository->id); })->get();
        $owners = User::whereHas("roles", function($q){ $q->where("name", "مالك-مخزن"); })->whereHas("repositories", function($p) use ($repository){ $p->where("repositories.id", $repository->id); })->get();
        return view('manager.Settings.show_workers')->with(['repository'=>$repository,'workers'=>$workers,'owners'=>$owners]);
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
        return back()->with('success',__('alerts.edit_employee_permissions_success'));
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
        return back()->with('success',__('alerts.edit_success'));
    }

    public function editWorkerInfo($id){
        $user = User::find($id);
        return view('manager.Settings.edit_worker_info')->with('user',$user);
    }
    public function updateWorkerInfo(Request $request , $id){
        $user = User::find($id);
        if($request->old_email != $request->email){
            $temp = User::where('email',$request->email)->first();
            if($temp)
                return back()->with('fail','هذا الايميل موجود مسبقا');
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return back()->with('success',__('alerts.edit_success'));
    }

    public function showWorkerSales($id , $repoId){   // this month sales
        $user = User::find($id);
        $repository = Repository::find($repoId); 
        //$invoices = $user->invoices()->paginate(30);
        $invoices = $user->invoices()->where('repository_id',$repository->id)->whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at','=',now()->month)->where('monthly_report_check',false)->get();
        return view('manager.Settings.worker_sales')->with(['user'=>$user,'invoices'=>$invoices]);
    }
    
    public function printSettings(Request $request,$id){
        $repository = Repository::find($id);
        $setting = $repository->setting;
        $print_prescription = false;
        $standard_printer = true;
        $thermal_printer = false;
        if($request->prescription)
            $print_prescription = true;
        if($request->printer_type == 'thermal'){
            $standard_printer = false;
            $thermal_printer = true;
        }

        $setting->update([
            'print_prescription' => $print_prescription,
            'standard_printer' => $standard_printer,
            'thermal_printer' => $thermal_printer,
        ]);
        $repository->update([
            'close_time' => $request->close_time,
            'note' => $request->note,
        ]);

        return back()->with('success' , 'update print settings');
    }

    public function discountSettings(Request $request , $id){
        $repository = Repository::find($id);
        $discount_by_percent = false;
        $discount_by_value = false;
        $discount_change_price = false;
        if($request->discount_by_percent)
            $discount_by_percent = true;
        if($request->discount_by_value)
            $discount_by_value = true;
        if($request->discount_change_price)
            $discount_change_price = true;
        $setting = $repository->setting;
        $setting->update([
            'discount_by_percent' => $discount_by_percent,
            'discount_by_value' => $discount_by_value,
            'discount_change_price' => $discount_change_price,
        ]);
        return back()->with('success',__('alerts.edit_success'));
    }

    public function viewAccount($id){
        $user = User::find($id);
        return view('manager.Settings.account')->with(['user'=>$user]);
    }

    public function changePassword(Request $request,$id){
        $user = User::find($id);
        if(password_verify($request->old_password , $user->password))
            if($request->new_password == $request->confirm_password){
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
                return back()->with('success',__('settings.password_change_success'));
            }
            else
                return back()->with('fail',__('settings.fail_confirm_password'));
            else
                return back()->with('fail',__('settings.fail_old_password'));
    }

    public function printSettingsIndex($id){
        $repository = Repository::find($id);
        return view('manager.Settings.print_settings')->with(['repository'=>$repository]);
    }
}
