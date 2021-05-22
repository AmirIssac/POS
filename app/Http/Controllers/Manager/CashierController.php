<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    //

    public function index(){
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        return view('manager.Cashier.index')->with(['repositories'=>$repositories]);   
    }

    public function dailyCashierForm($id){
        $repository = Repository::find($id);
        return view('manager.Cashier.daily_cashier')->with('repository',$repository);
    }
}
