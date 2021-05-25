<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
}
