<?php

namespace App\Http\Middleware;

use App\Repository;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $repository_id = $request->route()->parameter('repository_id');
        // check if the user really work in this repository
        $user = Auth::user();
        $user = User::find($user->id);
        $repository = Repository::find($repository_id);
        $check = DB::table('repository_user')->where('repository_id',$repository_id)->where('user_id',$user->id)->get();
        if($check->isEmpty())
        return redirect('/');
        return $next($request);
    }
}
