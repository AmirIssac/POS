<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('manager.Settings.min')->with('repository',$repository);
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
}
