<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        //return view('home');
        // get dashboard view according to user Role
       /* $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
            return view('dashboard');
        else return view('dashboard');*/
    }
    public function main(){    // get dashboard view according to user Role
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
            return view('dashboard');
        elseif($user->hasRole('مالك-مخزن'))
         return view('manager.Dashboard.index');
    }
}
